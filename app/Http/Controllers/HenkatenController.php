<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Line;
use App\Models\User;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Origin;
use App\Models\Approval;
use App\Models\Employee;
use App\Models\Henkaten;
use App\Models\PicActive;
use App\Models\HenkatenMan;
use App\Models\Troubleshoot;
use Illuminate\Http\Request;
use App\Models\EmployeeActive;
use App\Models\HenkatenMethod;
use PhpMqtt\Client\MqttClient;
use App\Exports\HenkatenExport;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use App\Models\HenkatenManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\SendWhatsAppNotification;
use PhpMqtt\Client\ConnectionSettings;
use App\Imports\HenkatenManagementImport;

class HenkatenController extends Controller
{
    public function mqttConnect($topic, $message)
    {
        $server   = '172.18.3.70';
        $port     = 1883;
        $clientId = '1234';
        // $username = 'fabian';
        // $password = '1234';
        $clean_session = false;
        $mqtt_version = MqttClient::MQTT_3_1_1;

        $connectionSettings = (new ConnectionSettings())
            // ->setUsername($username)
            // ->setPassword($password)
            ->setKeepAliveInterval(600)
            ->setConnectTimeout(10)
            ->setLastWillTopic('test')
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(1);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        try {
            $mqtt->connect($connectionSettings, $clean_session);

            $mqtt->publish(
                // topic
                $topic,
                // payload
                json_encode($message),
                // qos
                0,
                // retain
                false
            );
            sleep(1);
        } catch (\Exception $e) {
            // Handle the exception appropriately
            echo "Exception: " . $e->getMessage() . "\n";
        } finally {
            $mqtt->disconnect();
        }
    }
    
    public function pushData($is_updated)
    {
        // connection to pusher
        $options = [
            'cluster' => 'ap1',
            'encrypted' => true,
        ];

        $pusher = new Pusher('8ee9e8a15df964407aec', '36cee438943f3d49da89', '1741472', $options);

        // sending data
        $result = $pusher->trigger('henkaten', 'DashboardUpdated', $is_updated);

        return $result;
    }

    public function storeHenkaten(Request $request)
    {
        $type = $request->planned ? 'planned' : 'unplanned';

        // Use null coalescing operator to simplify date selection
        $dateRange = $request->planned ?? $request->unplanned;
        $dates = explode(' - ', $dateRange);
        
        // Trim and convert start and end dates to Y-m-d format
        [$startDate, $endDate] = array_map(function($date) {
            return Carbon::createFromFormat('m/d/Y', trim($date))->format('Y-m-d');
        }, $dates);

        // get origin id
        if(json_decode(auth()->user()->origin_id)){
            if(count(json_decode(auth()->user()->origin_id)) == 1){
                $empOrigin = json_decode(auth()->user()->origin_id)[0];
            }else{
                $empOrigin = $request->origin;
            }
        }else{
            $empOrigin = $request->origin ? $request->origin : auth()->user()->origin_id;
        }
        
        $docName = null;
        
        $originToGroupIdMap = [
            env('ORIGIN_MA') => env('GROUP_ID_MA') . '@g.us',
            env('ORIGIN_DC') => env('GROUP_ID_DC') . '@g.us',
            env('ORIGIN_ELC') => env('GROUP_ID_ELC') . '@g.us',
            env('ORIGIN_SEAT') => env('GROUP_ID_BODY') . '@g.us',
            env('ORIGIN_HANDLE') => env('GROUP_ID_BODY') . '@g.us',
        ];
        
        // Use the origin to get the group ID directly from the map, if available
        $groupId = $originToGroupIdMap[$empOrigin] ?? null;

        $currentTime = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        // get name
        $line = Line::select('name')
            ->where('id', $request->line)
            ->first();

        // get pic
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::with('firstPic')
            ->where('active_date', $current_date)
            ->where('origin_id', $empOrigin)
            ->first();

        $pivot = $pivot && $pivot->firstPic ? $pivot->firstPic->name : 'unknown';

        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];

        foreach ($shifts as $shift) {
            if ($shift->time_start > $shift->time_end) {
                // Shift spans midnight
                if ($currentTime->gte($shift->time_start) || $currentTime->lte($shift->time_end)) {
                    $shiftId = $shift->id;
                    break;
                }
            } else {
                // Regular shift
                if ($currentTime->between($shift->time_start, $shift->time_end)) {
                    $shiftId = $shift->id;
                    break;
                }
            }
        }        

        if (!$request->status) {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih status HENKATEN atau STOP!');
        }

        if ($request->category === '0') {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih kategori!');
        }

        if ($request->henkatenManagement === '0') {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih tabel henkaten management!');
        }

        try {
            DB::beginTransaction();

            // storing image
            if ($request->has('photo')) {
                $doc = $request->file('photo');
                $docName = time() . '-' . $doc->getClientOriginalName();
                $doc->move(public_path('uploads/ts_henkaten'), $docName);
            }

            $otherStats = Henkaten::select('status')
                ->where('is_done', '0')
                ->where('line_id', $request->line)
                ->where('4M', $request->type)
                ->where('date', 'LIKE', $current_date . '%')
                ->where('shift_id', $shiftId)
                ->get();

            if ($otherStats->isEmpty()) {
                try {
                    DB::beginTransaction();

                    // change line status
                    Line::where('id', $request->line)->update([
                        'status_' . $request->type => $request->status,
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->with('error', 'Data gagal disimpan!');
                }
            }

            if ($request->status === 'stop') {
                // Leveling priority
                foreach ($otherStats as $otherStat) {
                    if (isset($statusMappings[$otherStat->status])) {
                        $priority = $statusMappings[$otherStat->status]['priority'];
                        // If the priority is 2 (which is the biggest priority) we can immediately break the loop
                        if ($priority !== 2) {
                            // Insert into line table
                            try {
                                DB::beginTransaction();

                                // change line status
                                Line::where('id', $request->line)->update([
                                    'status_' . $request->type => $request->status,
                                ]);

                                DB::commit();
                            } catch (\Throwable $th) {
                                DB::rollBack();
                                return redirect()
                                    ->back()
                                    ->with('error', 'Data gagal disimpan!');
                            }
                        }
                    }
                }
            }

            $henkaten = Henkaten::create([
                'type' => $type,
                '4M' => $request->type,
                'status' => $request->status,
                'shift_id' => $shiftId,
                'line_id' => $request->line,
                'category' => $request->category,
                'henkaten_management_id' => $request->henkatenManagement,
                'abnormality' => $request->abnormality,
                'photo' => $docName,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'date' => Carbon::now(),
                'is_done' => '0',
            ]);

            // create approval
            Approval::create([
                'henkaten_id' => $henkaten->id,
            ]);

            $status = strtoupper($request->status);
            $date = Carbon::parse($henkaten->date)->format('j F Y, g:i A');
            $pic = auth()->user()->name;

            // send WA notif
            $token = '793D30579A77D4A0E12648872BFBB085';
            $phone = $groupId;
            $message = "```---- ``` *AIIA HENKATEN ALERT* ``` ----\n"
                . "LINE          : ``` *$line->name* ```\n"
                . "LINE STATUS   : ``` *$status* ```\n"
                . "4M            : $request->type\n"
                . "Category      : $request->category\n"
                . "ABNORMALITY   : $request->abnormality\n"
                . "TIME          : $date\n"
                . "PIC           : $pic\n"
                . "------------------------------```";
            
            // dispatch job
            SendWhatsAppNotification::dispatch($message, $token, $phone);

            // push to websocket
            $this->pushData(true);
            // $this->mqttConnect('update' , '1');

            DB::commit();
            return redirect()
                ->back()
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Data berhasil disimpan');
    }

    public function destroy(Request $request)
    {
        // get current line and 4M based on henkaten id
        $line = Henkaten::find($request->id);
        $toDate = Carbon::parse($line->date)->format('Y-m-d');
        $worstPriorityItem = 0;

        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];
        
        try {
            DB::beginTransaction();

            $henkaten = Henkaten::findOrFail($request->id);
            $henkaten->delete();

            $otherStats = Henkaten::select('status')
                // ->where('is_done', '0')
                ->where('line_id', $line->line_id)
                ->where('4M', $line->{"4M"})
                ->where('date', 'LIKE', $toDate . '%')
                ->where('shift_id', $line->shift_id)
                ->get();
                
            if ($otherStats->isEmpty()) {
                // update status
                Line::where('id', $line->line_id)
                        ->update([
                            'status_' . $line->{"4M"} => 'running'
                        ]);
            }else{
                foreach ($otherStats as $otherStat) {
                    if (isset($statusMappings[$otherStat->status])) {
                        $priority = $statusMappings[$otherStat->status]['priority'];
                        // If the priority is 2 (which is the biggest priority) we can immediately break the loop
                        if ($priority > $worstPriorityItem) {
                            $worstPriorityItem = $priority;
                            $status = $statusMappings[$otherStat->status]['overall'];
                            
                            // Insert into line table
                            try {
                                DB::beginTransaction();

                                // change line status
                                Line::where('id', $line->line_id)->update([
                                    'status_' . $line->{"4M"} => $status,
                                ]);

                                DB::commit();
                            } catch (\Throwable $th) {
                                DB::rollBack();
                                return redirect()
                                    ->back()
                                    ->with('error', 'Data gagal disimpan!');
                            }
                        }
                    }
                }
            }
            
            DB::commit();

            return redirect()->back()->with('success', 'Henkaten deleted successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function troubleshootHenkaten(Request $request)
    {
        /**
         * =========================
         * 1) Tentukan Origin
         * =========================
         */
        $userOrigin = auth()->user()->origin_id;

        // origin_id user bisa json array atau string biasa
        $decoded = null;
        if ($userOrigin) {
            $decoded = json_decode($userOrigin, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $decoded = null;
            }
        }

        if (is_array($decoded)) {
            // kalau user punya banyak origin, ambil dari form hidden origin
            $empOrigin = (count($decoded) === 1) ? $decoded[0] : $request->input('origin');
        } else {
            // origin single
            $empOrigin = $request->input('origin') ?: $userOrigin;
        }

        /**
         * =========================
         * 2) Ambil data Henkaten
         * =========================
         */
        $henkatenInfo = Henkaten::with(['shift', 'line', 'henkatenManagement'])
            ->where('id', $request->input('henkaten_id'))
            ->first();

        if (!$henkatenInfo) {
            return redirect()->back()->with('error', 'Data henkaten tidak ditemukan.');
        }

        /**
         * =========================
         * 3) Mapping Group WA
         * =========================
         */
        $originToGroupIdMap = [
            env('ORIGIN_MA')     => env('GROUP_ID_MA') . '@g.us',
            env('ORIGIN_DC')     => env('GROUP_ID_DC') . '@g.us',
            env('ORIGIN_ELC')    => env('GROUP_ID_ELC') . '@g.us',
            env('ORIGIN_SEAT')   => env('GROUP_ID_BODY') . '@g.us',
            env('ORIGIN_HANDLE') => env('GROUP_ID_BODY') . '@g.us',
        ];
        $groupId = $originToGroupIdMap[$empOrigin] ?? null;

        /**
         * =========================
         * 4) First PIC
         * =========================
         */
        $firstPicPivot = Pivot::with('firstPic')
            ->where('active_date', \Carbon\Carbon::parse($henkatenInfo->date)->format('Y-m-d'))
            ->where('origin_id', $empOrigin)
            ->first();

        $firstPic = ($firstPicPivot && $firstPicPivot->firstPic)
            ? $firstPicPivot->firstPic->name
            : 'unknown';

        /**
         * =========================
         * 5) VALIDATION (SERVER SIDE)
         * =========================
         * Catatan penting:
         * - doneBy di Blade adalah input text, jadi validasi harus required|string (bukan compare '0')
         * - inspection/picQuality/picSafety juga sebaiknya required
         */
        $rules = [
            'henkaten_id'      => 'required',
            '4M'               => 'required|string|in:man,machine,method,material',
            'status'           => 'required|string|in:henkaten,stop,running,off',
            'line'             => 'required|integer',
            'part'             => 'required|string|max:255',
            'beforeTreatment'  => 'required|string|in:ok,ng',
            'afterTreatment'   => 'required|string|in:ok,ng',
            'resultCheck'      => 'required|string|in:ok,ng',
            'inspection'       => 'required|string|in:need,no need',
            'picQuality'       => 'required|string|max:255',
            'picSafety'        => 'required|string|max:255',
            'doneBy'           => 'required|string|max:255',
            // troubleshoot textarea paduka display:none tapi tetap required di HTML, jadi wajib divalidasi juga:
            'troubleshoot'     => 'required|string',
            'photo'            => 'nullable|file|max:5120', // 5MB
        ];

        // tambahan khusus 4M=man
        if ($request->input('4M') === 'man') {
            $rules['before']   = 'nullable|array';
            $rules['after']    = 'nullable|array';
            $rules['before.*'] = 'nullable|integer';
            $rules['after.*']  = 'nullable|integer';
            $rules['picBefore']= 'nullable|integer';
            $rules['picAfter'] = 'nullable|integer';
        }

        $messages = [
            'part.required'            => 'Belum mengisi kolom Part!',
            'beforeTreatment.in'       => 'Belum memilih status Before Treatment!',
            'afterTreatment.in'        => 'Belum memilih status After Treatment!',
            'resultCheck.in'           => 'Belum memilih status Result Check!',
            'inspection.required'      => 'Belum memilih Inspection Report!',
            'picQuality.required'      => 'Belum mengisi PIC Quality!',
            'picSafety.required'       => 'Belum mengisi PIC Safety!',
            'doneBy.required'          => 'Belum mengisi Done By!',
            'troubleshoot.required'    => 'Kolom Troubleshoot wajib diisi!',
            'photo.max'                => 'Ukuran file maksimal 5MB.',
        ];

        $validated = \Validator::make($request->all(), $rules, $messages)->validate();

        /**
         * =========================
         * 6) Safety check untuk MAN: anti duplikat replacement
         * =========================
         */
        $employeeBefore = (array) $request->input('before', []);
        $employeeAfter  = (array) $request->input('after', []);

        if ($request->input('4M') === 'man') {
            $filteredAfter = array_values(array_filter($employeeAfter, function ($v) {
                return $v !== '0' && $v !== 0 && $v !== null && $v !== '';
            }));

            if (!empty($filteredAfter)) {
                $counts = array_count_values($filteredAfter);
                foreach ($counts as $val => $count) {
                    if ($count > 1) {
                        return redirect()->back()->withInput()->with('error', 'Employee cant be same!');
                    }
                }
            }
        }

        /**
         * =========================
         * 7) Simpan (Transaction rapih)
         * =========================
         */
        try {
            $docName = null;

            // upload file dulu (di luar transaction juga boleh, tapi ini aman)
            if ($request->hasFile('photo')) {
                $doc = $request->file('photo');
                $docName = time() . '-' . $doc->getClientOriginalName();
                $doc->move(public_path('uploads/ts_henkaten'), $docName);
            }

            DB::beginTransaction();

            $existingRecord = Troubleshoot::where('henkaten_id', $request->input('henkaten_id'))->first();

            // payload utama (dipakai untuk create/update)
            $baseData = [
                'henkaten_id'       => $request->input('henkaten_id'),
                'troubleshoot'      => $request->input('troubleshoot'),
                'result_check'      => $request->input('resultCheck'),
                'pic_safety'        => $request->input('picSafety'),
                'inspection_report' => $request->input('inspection'),
                'part'              => $request->input('part'),
                'before_treatment'  => $request->input('beforeTreatment'),
                'after_treatment'   => $request->input('afterTreatment'),
                'pic_quality'       => $request->input('picQuality'),
                'done_by'           => $request->input('doneBy'),
            ];

            // hanya set photo kalau ada upload baru (biar update ga meng-null photo lama)
            if ($docName !== null) {
                $baseData['photo'] = $docName;
            }

            /**
             * =========================
             * 7A) 4M != man -> 1 record saja (create/update)
             * =========================
             */
            if ($request->input('4M') !== 'man') {
                if (!$existingRecord) {
                    Troubleshoot::create($baseData);
                } else {
                    Troubleshoot::where('henkaten_id', $request->input('henkaten_id'))->update($baseData);
                }

                DB::commit();
            } else {
                /**
                 * =========================
                 * 7B) 4M == man
                 * Fix celah utama:
                 * - Kalau semua after[] = 0 dan picAfter=0, sebelumnya TIDAK ADA row tersimpan,
                 *   tapi tetap success. Sekarang: selalu minimal 1 record tersimpan.
                 */

                $picAfter  = $request->input('picAfter', '0');
                $picBefore = $request->input('picBefore', null);

                // 1) Siapkan list pairing employee before/after yang valid
                $pairs = [];
                foreach ($employeeAfter as $idx => $afterId) {
                    if ($afterId !== '0' && $afterId !== 0 && $afterId !== null && $afterId !== '') {
                        $pairs[] = [
                            'employee_before_id' => $employeeBefore[$idx] ?? null,
                            'employee_after_id'  => (int) $afterId,
                        ];
                    }
                }

                // 2) Kalau ada PIC replacement, treat sebagai "pair" khusus
                $hasPicReplacement = ($picAfter !== '0' && $picAfter !== 0 && $picAfter !== null && $picAfter !== '');
                $picPair = null;
                if ($hasPicReplacement) {
                    $picPair = [
                        'pic_before_id' => $picBefore ? (int) $picBefore : null,
                        'pic_after_id'  => (int) $picAfter,
                    ];
                }

                /**
                 * STRATEGY:
                 * - Sistem paduka sekarang menyimpan mapping replacement di tabel Troubleshoot yang sama.
                 * - Biar tidak success palsu, kita pastikan minimal 1 row tersimpan:
                 *   a) kalau ada $pairs => simpan semua pairs (create beberapa row kalau memang design-nya begitu)
                 *   b) kalau tidak ada pairs tapi ada picPair => simpan 1 row untuk picPair
                 *   c) kalau tidak ada keduanya => simpan 1 row base (tanpa mapping) -> ini menutup celah
                 */

                // kalau sudah ada existing, lebih aman: hapus dulu row mapping lama (supaya update tidak bikin data “nyangkut”)
                // OPTIONAL: kalau memang 1 henkaten_id boleh banyak row, ini penting agar update tidak ketuker.
                Troubleshoot::where('henkaten_id', $request->input('henkaten_id'))->delete();

                $createdAny = false;

                // a) simpan employee pairs
                if (!empty($pairs)) {
                    foreach ($pairs as $p) {
                        $payload = array_merge($baseData, $p);

                        if ($hasPicReplacement) {
                            $payload['pic_before_id'] = $picPair['pic_before_id'];
                            $payload['pic_after_id']  = $picPair['pic_after_id'];
                        }

                        Troubleshoot::create($payload);
                        $createdAny = true;
                    }
                }

                // b) simpan PIC pair saja jika tidak ada employee pairs
                if (!$createdAny && $hasPicReplacement) {
                    $payload = array_merge($baseData, [
                        'employee_before_id' => null,
                        'employee_after_id'  => null,
                        'pic_before_id'      => $picPair['pic_before_id'],
                        'pic_after_id'       => $picPair['pic_after_id'],
                    ]);

                    Troubleshoot::create($payload);
                    $createdAny = true;
                }

                // c) simpan base row kalau bener-bener ga ada mapping apapun
                if (!$createdAny) {
                    $payload = array_merge($baseData, [
                        'employee_before_id' => null,
                        'employee_after_id'  => null,
                        'pic_before_id'      => null,
                        'pic_after_id'       => null,
                    ]);

                    Troubleshoot::create($payload);
                }

                DB::commit();
            }

            /**
             * =========================
             * 8) Setelah simpan -> update status line / notif WA (logika lama paduka)
             * (di sini minimal troubleshoot SUDAH PASTI ada, jadi tidak ada success palsu)
             * =========================
             */

            $statusMappings = [
                'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
                'stop'     => ['priority' => 2, 'overall' => 'stop'],
            ];

            // ambil data untuk message
            $lineName         = $henkatenInfo->line->name;
            $status           = $henkatenInfo->status;
            $type             = $henkatenInfo->{'4M'};
            $category         = $henkatenInfo->category;
            $abnormality      = $henkatenInfo->abnormality;
            $time             = \Carbon\Carbon::parse($henkatenInfo->date)->format('j F Y, g:i A');
            $troubleshoot     = $request->input('troubleshoot');
            $resultCheck      = $request->input('resultCheck');
            $inspectionCheck  = $request->input('inspection');
            $part             = $request->input('part');
            $beforeTreatment  = $request->input('beforeTreatment');
            $afterTreatment   = $request->input('afterTreatment');
            $doneBy           = $request->input('doneBy');
            $troubleshootTime = \Carbon\Carbon::now()->format('j F Y, g:i A');

            // kalau status henkaten ini STOP, update line status berdasarkan item lain yg belum solved
            if ($request->input('status') === 'stop') {
                $otherStats = Henkaten::doesntHave('troubleshoot')
                    ->select('status')
                    ->where('is_done', '0')
                    ->where('line_id', $request->input('line'))
                    ->where('4M', $request->input('4M'))
                    ->get();

                if ($otherStats->isEmpty()) {
                    return redirect()->back()->with('success', 'Data berhasil disimpan!');
                }

                foreach ($otherStats as $otherStat) {
                    if (isset($statusMappings[$otherStat->status])) {
                        $priority = $statusMappings[$otherStat->status]['priority'];

                        // jika masih ada STOP yg belum beres, set status line ke STOP (paling tinggi)
                        if ($priority === 2) {
                            Line::where('id', $request->input('line'))->update([
                                'status_' . $request->input('4M') => $otherStat->status,
                            ]);

                            // notif WA (jika groupId ada)
                            if ($groupId) {
                                $token   = '793D30579A77D4A0E12648872BFBB085';
                                $phone   = $groupId;

                                $message = "```------ ``` *AIIA HENKATEN ALERT* ``` ------\n"
                                    . "LINE          : ``` *$lineName* ```\n"
                                    . "LINE STATUS   : ``` *$status* ```\n"
                                    . "4M            : $type\n"
                                    . "Category      : $category\n"
                                    . "ABNORMALITY   : $abnormality\n"
                                    . "TIME          : $time\n"
                                    . "PIC           : $firstPic\n"
                                    . "\n"
                                    . "```*TROUBLESHOOT*```\n"
                                    . "\n"
                                    . "TROUBLESHOOT       : $troubleshoot\n"
                                    . "TIME               : $troubleshootTime\n"
                                    . "RESULT CHECK       : $resultCheck\n"
                                    . "INSPECTION REPORT  : $inspectionCheck\n"
                                    . "PART               : $part\n"
                                    . "BEFORE TREATMENT   : $beforeTreatment\n"
                                    . "AFTER TREATMENT    : $afterTreatment\n"
                                    . "DONE BY            : $doneBy\n"
                                    . "\n"
                                    . "------ BY AISIN BISA ------```";

                                $curl = curl_init();
                                curl_setopt_array($curl, [
                                    CURLOPT_URL            => 'https://app.ruangwa.id/api/send_message',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING       => '',
                                    CURLOPT_MAXREDIRS      => 10,
                                    CURLOPT_TIMEOUT        => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST  => 'POST',
                                    CURLOPT_POSTFIELDS     => 'api_key=' . $token . '&phone=' . $phone . '&message=' . $message,
                                ]);

                                curl_exec($curl);
                                curl_close($curl);
                            }

                            return redirect()->back()->with('success', 'Data berhasil disimpan!');
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function troubleShootApproval(Request $request)
    {
        // get origin id
        if(json_decode(auth()->user()->origin_id)){
            if(count(json_decode(auth()->user()->origin_id)) == 1){
                $empOrigin = json_decode(auth()->user()->origin_id)[0];
            }else{
                $empOrigin = $request->origin;
            }
        }else{
            $empOrigin = $request->origin ? $request->origin : auth()->user()->origin_id;
        }

        $originToGroupIdMap = [
            env('ORIGIN_MA') => env('GROUP_ID_MA') . '@g.us',
            env('ORIGIN_DC') => env('GROUP_ID_DC') . '@g.us',
            env('ORIGIN_ELC') => env('GROUP_ID_ELC') . '@g.us',
            env('ORIGIN_SEAT') => env('GROUP_ID_BODY') . '@g.us',
            env('ORIGIN_HANDLE') => env('GROUP_ID_BODY') . '@g.us',
        ];
        
        // Use the origin to get the group ID directly from the map, if available
        $groupId = $originToGroupIdMap[$empOrigin] ?? null;

        // get henkaten info
        $henkatenInfo = Henkaten::with(['troubleshoot.employee', 'shift', 'line', 'henkatenManagement'])
            ->where('id', $request->henkaten_id)
            ->first();

        // get first pic
        $firstPic = Pivot::with('firstPic')
            ->where('active_date', Carbon::parse($henkatenInfo->date)->format('Y-m-d'))
            ->where('origin_id', $empOrigin)
            ->first();
            
        $firstPic = $firstPic && $firstPic->firstPic ? $firstPic->firstPic->name : 'unknown';

        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];

        $currentTimeFull = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        // get current shift id
        foreach ($shifts as $shift) {
            if ($shift->time_start > $shift->time_end) {
                // Shift spans midnight
                if ($currentTimeFull->gte($shift->time_start) || $currentTimeFull->lte($shift->time_end)) {
                    $shiftId = $shift->id;
                    break;
                }
            } else {
                // Regular shift
                if ($currentTimeFull->between($shift->time_start, $shift->time_end)) {
                    $shiftId = $shift->id;
                    break;
                }
            }
        }      

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        // get all henkaten data
        $lineName = $henkatenInfo->line->name;
        $status = $henkatenInfo->status;
        $type = $henkatenInfo->{'4M'};
        $category = $henkatenInfo->category;
        $abnormality = $henkatenInfo->abnormality;
        $time = Carbon::parse($henkatenInfo->date)->format('j F Y, g:i A');
        $troubleshoot = $henkatenInfo->troubleshoot->troubleshoot;
        $troubleshootTime = Carbon::parse($henkatenInfo->troubleshoot->created_at)->format('j F Y, g:i A');
        $resultCheck = $henkatenInfo->troubleshoot->result_check;
        $inspectionCheck = $henkatenInfo->troubleshoot->inspection_report;
        $part = $henkatenInfo->troubleshoot->part;
        $beforeTreatment = $henkatenInfo->troubleshoot->before_treatment;
        $afterTreatment = $henkatenInfo->troubleshoot->after_treatment;
        $picSafety = $henkatenInfo->troubleshoot->pic_safety;
        $picQuality = $henkatenInfo->troubleshoot->pic_quality;
        $doneBy = $henkatenInfo->troubleshoot->done_by;
        $pic = auth()->user()->name;

        try {
            DB::beginTransaction();

            // make the approval sequential
            if (auth()->user()->role === 'LDR') {
                Approval::where('henkaten_id', $request->henkaten_id)->update([
                    'ldr' => auth()->user()->name,
                    'status' => 'Leader',
                ]);

                // change approver and is_done status
                Henkaten::where('id', $request->henkaten_id)->update([
                    'is_done' => '1',
                ]);

                // send whatsapp notification
                $token = '793D30579A77D4A0E12648872BFBB085';
                $phone = $groupId;
                $message = "```------ ``` *AIIA HENKATEN ALERT* ``` ------\n"
                    . "LINE          : ``` *$lineName* ```\n"
                    . "LINE STATUS   : ``` *$status* ```\n"
                    . "4M            : $type\n"
                    . "Category      : $category\n"
                    . "ABNORMALITY   : $abnormality\n"
                    . "TIME          : $time\n"
                    . "PIC           : $pic\n"
                    . "\n"
                    . "```*TROUBLESHOOT*```\n"
                    . "\n"
                    . "TROUBLESHOOT       : $troubleshoot\n"
                    . "TIME               : $troubleshootTime\n"
                    . "RESULT CHECK       : $resultCheck\n"
                    . "PIC SAFETY         : $picSafety\n"
                    . "INSPECTION REPORT  : $inspectionCheck\n"
                    . "PART               : $part\n"
                    . "BEFORE TREATMENT   : $beforeTreatment\n"
                    . "AFTER TREATMENT    : $afterTreatment\n"
                    . "PIC QUALITY        : $picQuality\n"
                    . "DONE BY            : $doneBy\n"
                    . "\n"
                    . "------ BY AISIN BISA ------```";
                
                 // dispatch job
                SendWhatsAppNotification::dispatch($message, $token, $phone);
                
            } elseif (auth()->user()->role === 'SPV') {
                Approval::where('henkaten_id', $request->henkaten_id)->update([
                    'spv' => auth()->user()->name,
                    'status' => 'Supervisor',
                ]);

            } else {
                Approval::where('henkaten_id', $request->henkaten_id)->update([
                    'mgr' => auth()->user()->name,
                    'status' => 'Manager',
                ]);
            }

            // search other henkaten where status henkaten
            $otherStats = Henkaten::with('shift')
                ->where('date', 'LIKE', $currentDate . '%')
                ->where('is_done', '0')
                ->where('line_id', $request->line)
                ->where('4M', $request->{"4M"})
                ->whereHas('shift', function ($query) use ($currentTime) {
                    $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
                })
                ->get();

            if ($request->status === 'stop') {
                if ($otherStats->isEmpty()) {
                    try {
                        DB::beginTransaction();

                        // change line status if status before is 'stop'
                        // change to henkaten, not running
                        if ($request->status) {
                            Line::where('id', $request->line)->update([
                                'status_' . $request->{"4M"} => 'henkaten',
                            ]);
                        }

                        DB::commit();
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->with('error', 'Data gagal disimpan!');
                    }
                }
            }
            
            // Leveling priority
            $worstPriority = 0;
            foreach ($otherStats as $otherStat) {
                $status = $otherStat->status;
                if (!isset($statusMappings[$status])) {
                    continue;
                }
                $priority = $statusMappings[$status]['priority'];
                // If the priority is 2 (which is the highest priority), update and break the loop
                if ($priority > $worstPriority) {
                    $worstPriority = $priority;
                    try {
                        DB::beginTransaction();

                        $lineStatus = ($shiftId !== $henkatenInfo->shift_id) ? ($status !== 'STOP' ? 'running' : 'stop') : $status;

                        Line::where('id', $request->line)->update([
                            'status_' . $request->{"4M"} => $lineStatus,
                        ]);

                        DB::commit();
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->with('error', 'Data gagal disimpan!');
                    }
                }
            }


            DB::commit();

            // push to websocket
            $this->pushData(true);
            // $this->mqttConnect('update' , '1');

            return redirect()
                ->back()
                ->with('success', 'Berhasil diapprove!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()
                    ->back()
                    ->with('error', 'Gagal diapprove!');
        }
    }

    public function history($originId = null)
    {
        // Get the origin id from the authenticated user
        if(json_decode(auth()->user()->origin_id)){
            if(count(json_decode(auth()->user()->origin_id)) == 1){
                $empOrigin = json_decode(auth()->user()->origin_id)[0]; // Get the first origin ID from the JSON field
                $origins = Origin::where('id', $empOrigin)->first();
            }else{
                $empOrigin = $originId ? $originId : auth()->user()->origin_id;
                $origins = Origin::where('id', $empOrigin)->first();
            }
        }else{
            $empOrigin = $originId ? $originId : auth()->user()->origin_id;
            $origins = Origin::where('id', $empOrigin)->first();
        }

        $henkatenHistory = Henkaten::with(['line.origin', 'approval', 'henkatenManagement'])
                        ->whereHas('line', function ($query) use ($empOrigin) {
                            $query->where('origin_id', $empOrigin);
                        })
                        ->orderBy('date', 'desc')
                        ->get();
                        
        return view('pages.website.history', [
            'henkatenHistory' => $henkatenHistory,
            'lines' => Line::where('origin_id', $empOrigin)->get(),
        ]);
    }

    public function henkatenManagementIndex($originId = null)
    {
        if(json_decode(auth()->user()->origin_id)){
            if(count(json_decode(auth()->user()->origin_id)) == 1){
                $empOrigin = json_decode(auth()->user()->origin_id)[0]; // Get the first origin ID from the JSON field
                $origins = Origin::where('id', $empOrigin)->first();
            }else{
                $empOrigin = $originId ? $originId : auth()->user()->origin_id;
                $origins = Origin::where('id', $empOrigin)->first();
            }
        }else{
            $empOrigin = $originId ? $originId : auth()->user()->origin_id;
            $origins = Origin::where('id', $empOrigin)->first();
        }
        
        $henkatenManagement = HenkatenManagement::where('origin_id', $origins->id)->get();
        
        return view('pages.website.henkatenManagement', [
            'henkatenManagements' => $henkatenManagement
        ]);
    }

    public function henkatenManagementStore(Request $request)
    {
        $henkatenManagement = $request->input('repeater-group');

        // Initialize an array to store counts for each combination of fields
        $fieldCombinationCounts = [];

        // Loop through each entry and count occurrences of each combination of fields
        foreach ($henkatenManagement as $entry) {
            $fieldCombination = [strtoupper($entry['henkaten_item']), strtoupper($entry['table_no']), strtoupper($entry['4M'])];

            $fieldCombinationString = implode('|', $fieldCombination);

            if (!isset($fieldCombinationCounts[$fieldCombinationString])) {
                $fieldCombinationCounts[$fieldCombinationString] = 1;
            } else {
                $fieldCombinationCounts[$fieldCombinationString]++;
            }
        }

        // Check for duplicates
        $duplicates = [];
        foreach ($fieldCombinationCounts as $fieldCombinationString => $count) {
            if ($count > 1) {
                $fields = explode('|', $fieldCombinationString);
                $duplicates[] = [
                    'henkaten_item' => $fields[0],
                    'table_no' => $fields[1],
                    '4M' => $fields[2],
                ];
            }
        }

        // Check if there are duplicates
        if (!empty($duplicates)) {
            // Handle the case where duplicates are found
            return redirect()
                ->back()
                ->with('error', 'Data tidak boleh sama!');
        }

        foreach ($henkatenManagement as $name) {
            // error handling when theme already exists in database
            $existingTheme = HenkatenManagement::where('table_no', $name['table_no'])->first();
            if ($existingTheme) {
                return redirect()
                    ->back()
                    ->with('error', 'Henkaten management already exist!');
            }
        }

        try {
            DB::beginTransaction();

            foreach ($henkatenManagement as $entry) {
                HenkatenManagement::create([
                    'table_no' => $entry['table_no'],
                    'henkaten_item' => $entry['henkaten_item'],
                    '4M' => $entry['4M'],
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Henkaten Management created successfully');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'Henkaten Management creation failed!');
        }
    }

    public function henkatenManagementRemove(Request $request)
    {
        HenkatenManagement::where('origin_id', $request->origin_id)->delete();

        return redirect()->back()->with('success', 'All records for your origin have been removed.');
    }

    public function getNextShiftUuid($currentShiftUuid)
    {
        // Assuming Shift is your model name and it has 'name' and 'id' columns
        $shifts = \App\Models\Shift::whereIn('name', ['Shift 1', 'Shift 2', 'Shift 3'])
            ->get()
            ->keyBy('name');

        // Map the shift names to their IDs
        $shiftsMap = [
            $shifts['Shift 1']->id => $shifts['Shift 3']->id,
            $shifts['Shift 2']->id => $shifts['Shift 1']->id,
            $shifts['Shift 3']->id => $shifts['Shift 2']->id,
        ];

        return $shiftsMap[$currentShiftUuid] ?? null; // Return null or handle invalid UUID
    }

    public function autoUpdate()
    {
        // Set the current time to the start of the current week, then subtract a week
        $previousWeekStart = Carbon::now()
            ->startOfWeek()
            ->subWeek()
            ->format('Y-m-d');

        // Set the time to the end of that week
        $previousWeekEnd = Carbon::now()
            ->startOfWeek()
            ->subWeek()
            ->endOfWeek()
            ->format('Y-m-d');

        // for employee
        $currentShifts = EmployeeActive::select('employee_id', 'shift_id', 'line_id', 'pos_id')
            ->where('active_from', '<=', $previousWeekEnd)
            ->where('expired_at', '>=', $previousWeekStart)
            ->get();

        // for pic or jp
        $currentShiftsPic = PicActive::select('employee_id', 'shift_id', 'line_id')
            ->where('active_from', '<=', $previousWeekEnd)
            ->where('expired_at', '>=', $previousWeekStart)
            ->get();

        $newShifts = $currentShifts->map(function ($employee) {
            $nextShiftUuid = $this->getNextShiftUuid($employee->shift_id); // Implement this method to determine the next shift

            return [
                'employee_id' => $employee->employee_id,
                'shift_id' => $nextShiftUuid,
                'line_id' => $employee->line_id,
                'pos_id' => $employee->pos_id,
                'active_from' => Carbon::now()
                    ->startOfWeek()
                    ->format('Y-m-d'),
                'expired_at' => Carbon::now()
                    ->endOfWeek()
                    ->format('Y-m-d'),
            ];
        });

        $newShiftsPic = $currentShiftsPic->map(function ($employee) {
            $nextShiftUuid = $this->getNextShiftUuid($employee->shift_id); // Implement this method to determine the next shift

            return [
                'employee_id' => $employee->employee_id,
                'shift_id' => $nextShiftUuid,
                'line_id' => $employee->line_id,
                'active_from' => Carbon::now()
                    ->startOfWeek()
                    ->format('Y-m-d'),
                'expired_at' => Carbon::now()
                    ->endOfWeek()
                    ->format('Y-m-d'),
            ];
        });

        $newShifts = $newShifts->toArray();
        $newShiftsPic = $newShiftsPic->toArray();

        try {
            DB::beginTransaction();

            foreach ($newShifts as $newShift) {
                EmployeeActive::create($newShift);
            }

            foreach ($newShiftsPic as $newShiftPic) {
                PicActive::create($newShiftPic);
            }

            DB::commit();
            return ['success'];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'error' => $th->getMessage(),
            ];
        }
    }

    public function autoUpdateStatus()
    {
        $currentStatus = 'henkaten';
        $newStatus = 'running';

        $columnsToUpdate = [
            'status_man' => $newStatus,
            'status_method' => $newStatus,
            'status_material' => $newStatus,
            'status_machine' => $newStatus,
        ];

        try {
            DB::beginTransaction();

            // 1. Update lines where origin_id is not ELC
            $linesToUpdate1 = Line::whereNot('origin_id', env('ORIGIN_ELC'))
                ->where(function ($query) use ($currentStatus) {
                    $query->where('status_man', $currentStatus)
                        ->orWhere('status_method', $currentStatus)
                        ->orWhere('status_material', $currentStatus)
                        ->orWhere('status_machine', $currentStatus);
                })
                ->pluck('id');

            if ($linesToUpdate1->isEmpty() == false) {
                Line::whereIn('id', $linesToUpdate1)->update($columnsToUpdate);
                DB::commit();
            }

            // 2. Update lines where origin_id is ELC and is_done is 1
            $linesNotToUpdate = Henkaten::whereHas('line', function ($query) use ($currentStatus) {
                                        $query->whereIn('origin_id', [env('ORIGIN_ELC'), env('ORIGIN_SEAT'), env('ORIGIN_HANDLER')])
                                                ->where('is_done', '0');
                                        })
                                        ->pluck('line_id');

            $oppositeLines = Henkaten::whereHas('line', function ($query) use ($currentStatus, $linesNotToUpdate) {
                            $query->whereIn('origin_id', [env('ORIGIN_ELC'), env('ORIGIN_SEAT'), env('ORIGIN_HANDLER')])
                                    ->where('is_done', '1')
                                    ->whereNotIn('line_id', $linesNotToUpdate);
                            })
                            ->pluck('line_id');
                            
            if ($oppositeLines->isEmpty() == false) {
                Line::whereIn('id', $oppositeLines)->update($columnsToUpdate);
                DB::commit();
            }

            // check if there is henkaten with end date not current date
            // $rangeHenkaten = Henkaten::select('line_id','4M')->where('end_date', '<', Carbon::now()->format('Y-m-d'))->get();
            // $updates = [];
            // foreach ($rangeHenkaten as $henkaten) {
            //     if (isset($henkaten->line_id, $henkaten->{"4M"})) {
            //         $updates[$henkaten->line_id]['status_' . $henkaten->{"4M"}] = 'henkaten';
            //     }
            // }

            // foreach ($updates as $lineId => $fields) {
            //     Line::where('id', $lineId)->update($fields);
            // }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd('Caught an exception: ' . $th->getMessage());
        }
    }

    public function henkatenImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        $origin = $request->origin;

        Excel::import(new HenkatenManagementImport($origin), $request->file('file'));

        return redirect()->back()->with('success', 'Henkaten data imported successfully!');
    }

    public function export(Request $request)
    {
        $originId = $request->input('origin_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        return Excel::download(new HenkatenExport($originId, $startDate, $endDate), 'henkaten.xlsx');
    }

    public function editHankatenManagement($table , $type, $item, $newTable, $newType, $newItem)
    {
        $newTable = $newTable ?? $table;
        $newType = $newType ?? $type;
        $newItem = $newItem?? $item;

        try {
            DB::beginTransaction();

            HenkatenManagement::where('table_no', $table)
                                ->where('4M', $type)
                                ->where('henkaten_item', $item)
                                ->update([
                                    'table_no' => $newTable,
                                    '4M' => $newType,
                                    'henkaten_item' => $newItem,
                                ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'table' => $newTable,
                'type' => $newType,
                'item' => $newItem,
                'message' => 'Data berhasil diupdate!'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
        
    }
}
