<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\User;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Approval;
use App\Models\Employee;
use App\Models\Henkaten;
use App\Models\HenkatenMan;
use App\Models\Troubleshoot;
use Illuminate\Http\Request;
use App\Models\EmployeeActive;
use App\Models\HenkatenMethod;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use App\Models\HenkatenManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HenkatenController extends Controller
{
    public function storeHenkaten(Request $request)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;
        
        $currentTime = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        // get name 
        $line = Line::select('name')->where('id', $request->line)->first();
        
        // get pic
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::with('firstPic')
            ->where('active_date', $current_date)
            ->where('origin_id', $empOrigin)
            ->first();
            
        if(!$pivot){
            $pivot = 'unknown';
        }else{
            $pivot = $pivot->firstPic->name;
        }

        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];

        foreach ($shifts as $shift) {
            if ($currentTime->between($shift->time_start, $shift->time_end)) {
                $shiftId = $shift->id;
                break;
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

            $otherStats = Henkaten::select('status')
                ->where('is_done', '0')
                ->where('line_id', $request->line)
                ->where('4M', $request->type)
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
                '4M' => $request->type,
                'status' => $request->status,
                'shift_id' => $shiftId,
                'line_id' => $request->line,
                'category' => $request->category,
                'henkaten_management_id' => $request->henkatenManagement,
                'abnormality' => $request->abnormality,
                'date' => Carbon::now(),
                'is_done' => '0',
            ]);

            // create approval
            Approval::create([
                'henkaten_id' => $henkaten->id,
            ]);

            // send WA notif
            $token = 'v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1';
            $phone = '081280613890';
            $message = sprintf("---- ``` AIIA HENKATEN ALERT ``` ---- %c%cLINE                      : $line->name %cLINE STATUS       : $request->status %c4M                         : $request->type %cCategory               : $request->category %cABNORMALITY    : $request->abnormality %cTROUBLESHOOT  :  TBC  %cPIC                         : $pivot %c%c ---------------- BY AISIN BISA ----------------", 10, 10, 10, 10, 10, 10, 10,10,10,10);
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $phone . '&message=' . $message,
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

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

    public function troubleshootHenkaten(Request $request)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        // get phone number
        $empPhone = User::select('phone_number')
            ->where('origin_id', $empOrigin)
            ->where('role', 'LDR')
            ->get();

        // get all henkaten info
        $henkatenInfo = Henkaten::with(['shift', 'line', 'henkatenManagement'])
            ->where('id', $request->henkaten_id)
            ->get();

        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];

        if (!$request->part) {
            return redirect()
                ->back()
                ->with('error', 'Belum mengisi kolom part!');
        }

        if ($request->beforeTreatment === '0') {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih status before treatment!');
        }

        if ($request->afterTreatment === '0') {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih status after treatment!');
        }

        if ($request->resultCheck === '0') {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih status result check!');
        }

        if ($request->doneBy === '0') {
            return redirect()
                ->back()
                ->with('error', 'Belum memilih PIC penanganan!');
        }

        $employeeAfter = $request->after;

        try {
            DB::beginTransaction();

            if ($request->{"4M"} == 'man') {
                // count same value of input
                $nameCounts = array_count_values($employeeAfter);

                // Check for duplicates
                $duplicates = [];
                foreach ($nameCounts as $value => $count) {
                    if ($count > 1 && $value != 0) {
                        $duplicates[] = $value;
                    }
                }

                // Check if there are duplicates
                if (!empty($duplicates)) {
                    return redirect()
                        ->back()
                        ->with('error', 'Employee cant be same!');
                }

                for ($i = 0; $i < count($request->after); $i++) {
                    if ($request->after[$i] !== '0') {
                        Troubleshoot::create([
                            'henkaten_id' => $request->henkaten_id,
                            'troubleshoot' => $request->troubleshoot,
                            'employee_before_id' => $request->before[$i],
                            'employee_after_id' => $request->after[$i],
                            'result_check' => $request->resultCheck,
                            'inspection_report' => $request->inspection,
                            'part' => $request->part,
                            'before_treatment' => $request->beforeTreatment,
                            'after_treatment' => $request->afterTreatment,
                            'done_by' => $request->doneBy,
                        ]);
                    }
                    DB::commit();
                }
            } else {
                // Insert troubleshoot for non-'man' case
                Troubleshoot::create([
                    'henkaten_id' => $request->henkaten_id,
                    'troubleshoot' => $request->troubleshoot,
                    'result_check' => $request->resultCheck,
                    'inspection_report' => $request->inspection,
                    'part' => $request->part,
                    'before_treatment' => $request->beforeTreatment,
                    'after_treatment' => $request->afterTreatment,
                    'done_by' => $request->doneBy,
                ]);

                DB::commit();
            }

            if ($request->status === 'stop') {
                // Check if there is any problem not solved yet (stop content only)
                $otherStats = Henkaten::doesntHave('troubleshoot')
                    ->select('status')
                    ->where('is_done', '0')
                    ->where('line_id', $request->line)
                    ->where('4M', $request->{"4M"})
                    ->get();

                if ($otherStats->isEmpty()) {
                    return redirect()
                        ->back()
                        ->with('success', 'Data berhasil disimpan!');
                }

                // Leveling priority
                foreach ($otherStats as $otherStat) {
                    if (isset($statusMappings[$otherStat->status])) {
                        $priority = $statusMappings[$otherStat->status]['priority'];

                        // If the priority is 2 (which is the biggest priority) we can immediately break the loop
                        if ($priority === 2) {
                            // Insert into line table
                            Line::where('id', $request->line)->update([
                                'status_' . $request->{"4M"} => $otherStat->status,
                            ]);

                            DB::commit();
                            return redirect()
                                ->back()
                                ->with('success', 'Data berhasil disimpan!');
                        }
                    }
                }
            }

            DB::commit();

            $lineName = $henkatenInfo->line->name;
            $shiftName = $henkatenInfo->shift->name;
            $abnormality = $henkatenInfo->abnormality;
            $troubleshoot = $henkatenInfo->troubleshoot;
            $time = Carbon::parse($henkatenInfo->date)->format('l, j F Y');

            // send whatsapp notification
            foreach ($empPhone as $empPhone) {
                $token = 'v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1';
                $phone = $empPhone->phone_number;
                $message = sprintf("```---- ``` *HENKATEN ALERT* ``` ----%cLINE          : $lineName %cLINE STATUS       : $request->status %c4M     : $request->{'4M'} %cSHIFT   : $shiftName %cABNORMALITY : $abnormality %cTIME      :  $time %c-------------------------``` *TROUBLESHOOTS* ``` %cTROUBLESHOOT          : $troubleshoot", 10, 10, 10, 10, 10, 10, 10, 10);
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $phone . '&message=' . $message,
                ]);

                $response = curl_exec($curl);
                curl_close($curl);
            }

            return redirect()
                ->back()
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function troubleShootApproval(Request $request)
    {
        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $worstPriority = 0;

        try {
            DB::beginTransaction();

            // make the approval sequential
            if (auth()->user()->role === 'LDR') {
                Approval::where('henkaten_id', $request->henkaten_id)->update([
                    'ldr' => auth()->user()->name,
                    'status' => 'Leader',
                ]);
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

                // change approver and is_done status
                Henkaten::where('id', $request->henkaten_id)->update([
                    'is_done' => '1',
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
                        if ($request->status) {
                            Line::where('id', $request->line)->update([
                                'status_' . $request->{"4M"} => 'running',
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
            foreach ($otherStats as $otherStat) {
                if (isset($statusMappings[$otherStat->status])) {
                    $priority = $statusMappings[$otherStat->status]['priority'];
                    // If the priority is 2 (which is the biggest priority) we can immediately break the loop
                    if ($priority > $worstPriority) {
                        $worstPriority = $priority;
                        // Insert into line table
                        try {
                            DB::beginTransaction();
                            // change line status
                            Line::where('id', $request->line)->update([
                                'status_' . $request->{"4M"} => $otherStat->status,
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

            DB::commit();

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

    public function history()
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        $henkatenHistory = Henkaten::with(['line.origin', 'approval'])->whereHas('line', function ($query) use ($empOrigin) {
            $query->where('origin_id', $empOrigin);
        });

        return view('pages.website.history', [
            'henkatenHistory' => $henkatenHistory->get(),
            'lines' => Line::where('origin_id', $empOrigin)->get(),
        ]);
    }

    public function henkatenManagementIndex()
    {
        $henkatenManagement = HenkatenManagement::all();
        return view('pages.website.henkatenManagement', ['henkatenManagements' => $henkatenManagement]);
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

        $currentShifts = EmployeeActive::select('employee_id', 'shift_id', 'line_id', 'pos_id')
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

        $newShifts = $newShifts->toArray();

        try {
            DB::beginTransaction();

            foreach ($newShifts as $newShift) {
                EmployeeActive::create($newShift);
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
}
