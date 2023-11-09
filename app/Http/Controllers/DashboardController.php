<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Theme;
use App\Models\Employee;
use App\Models\HenkatenMan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HenkatenMethod;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function index()
    {
        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::with('theme')
            ->with('firstPic')
            ->with('secondPic')
            ->where('active_date', $current_date)
            ->first();

        $currentDate = Carbon::now()->format('Y-m-d');

        // get all henkaten history
        $manData = HenkatenMan::with('line')->where('status_after', null)->get();
        $methodData = HenkatenMethod::with('line')->where('status_after', null)->get();
        $machineData = HenkatenMachine::with('line')->where('status_after', null)->get();
        $materialData = HenkatenMaterial::with('line')->where('status_after', null)->get();

        // Merge the data and add the type field
        $combinedData = [];

        foreach ($manData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Man',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'troubleshoot' => $troubleshoot
            ];
        }

        foreach ($methodData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Method',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'line' => $item->line->name,
                'troubleshoot' => $troubleshoot
            ];
        }

        foreach ($machineData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Machine',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'line' => $item->line->name,
                'troubleshoot' => $troubleshoot
            ];
        }

        foreach ($materialData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Material',
                'status' => $item->status,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'line' => $item->line->name,
                'troubleshoot' => $troubleshoot
            ];
        }

        // in this page we will get all line status
        return view('pages.website.dashboard', [
            'pivot' => $pivot,
            'themes' => Theme::all(),
            'employees' => Employee::select('id', 'name')
                ->whereIn('role', ['Leader', 'JP'])
                ->get(),
            'lines' => Line::all(),
            'histories' => $combinedData
        ]);
    }

    public function dashboardLine(Line $lineId)
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        // get all henkaten history
        $manData = HenkatenMan::where('line_id', $lineId->id)->get();
        $methodData = HenkatenMethod::where('line_id', $lineId->id)->get();
        $machineData = HenkatenMachine::where('line_id', $lineId->id)->get();
        $materialData = HenkatenMaterial::where('line_id', $lineId->id)->get();

        // get man power at spesific line and shift


        // Merge the data and add the type field
        $combinedData = [];

        foreach ($manData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Man',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'troubleshoot' => $troubleshoot
            ];
        }

        foreach ($methodData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Method',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'troubleshoot' => $troubleshoot
            ];
        }

        foreach ($machineData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Machine',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'troubleshoot' => $troubleshoot
            ];
        }

        foreach ($materialData as $item) {
            $troubleshoot = $item->troubleshoot ? $item->troubleshoot : 'Belum ditangani';
            $combinedData[] = [
                'id' => $item->id,
                'type' => 'Material',
                'status' => $item->status,
                'status_after' => $item->status_after,
                'problem' => $item->henkaten_problem,
                'description' => $item->henkaten_description,
                'date' => $item->date,
                'troubleshoot' => $troubleshoot
            ];
        }

        return view('pages.website.line', [
            'line' => Line::findOrFail($lineId->id),
            'employees' => Employee::all(),
            'histories' => $combinedData,
            'methodHistory' => HenkatenMethod::where('line_id', $lineId->id)->where('date', 'like', '%' . $currentDate . '%')->get(),
            'machineHistory' => HenkatenMachine::where('line_id', $lineId->id)->where('date', 'like', '%' . $currentDate . '%')->get(),
            'manHistory' => HenkatenMan::where('line_id', $lineId->id)->where('date', 'like', '%' . $currentDate . '%')->get(),
            'materialHistory' => HenkatenMaterial::where('line_id', $lineId->id)->where('date', 'like', '%' . $currentDate . '%')->get(),
        ]);
    }

    public function storeHenkaten($table, $status, $lineId, $pic = null, $problem = null, $description = null)
    {
        // get all data from FE
        $lineId = $lineId ? $lineId : null;
        $status = $status ? $status : null;
        $table = $table ? $table : null;

        // initiate model
        $methodModel = new HenkatenMethod();
        $machineModel = new HenkatenMachine();
        $materialModel = new HenkatenMaterial();

        $currentTime = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        // check the current status and the request status
        // $currentStatus = Line::select('status_' . $table)->where('id', $lineId)->first();
        // if ($currentStatus->{'status_' . $table} == $status){
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Status sama!'
        //     ]);
        // }

        foreach ($shifts as $shift) {
            if ($currentTime->between($shift->time_start, $shift->time_end)) {
                $shiftId = $shift->id;
                break;
            }
        }

        function insertHenkaten($model, $shiftId, $lineId, $pic = null, $status, $problem = null, $description = null)
        {
            $result = $model->create([
                'shift_id' => $shiftId,
                'line_id' => $lineId,
                'pic' => $pic,
                'status' => $status,
                'henkaten_problem' => $problem,
                'henkaten_description' => $description,
                'type' => null,
                'date' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return $result;
        }

        try {
            DB::beginTransaction();

            if ($table == 'method') {
                // insert into henkaten table
                insertHenkaten($methodModel, $shiftId, $lineId, $pic, $status, $problem, $description);

                // insert into line table
                Line::where('id', $lineId)->update([
                    'status_method' => $status
                ]);
            } else if ($table == 'machine') {
                // insert into henkaten table
                insertHenkaten($machineModel, $shiftId, $lineId, $pic, $status, $problem, $description);

                // insert into line table
                Line::where('id', $lineId)->update([
                    'status_machine' => $status
                ]);
            } else if ($table == 'material') {
                // insert into henkaten table
                insertHenkaten($materialModel, $shiftId, $lineId, $pic, $status, $problem, $description);

                // insert into line table
                Line::where('id', $lineId)->update([
                    'status_material' => $status
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Henkaten berhasil tersimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function troubleshootHenkaten(Request $request)
    {
        $troubleshoot = $request->get('troubleshoot');
        $approvedBy = $request->get('approvedBy');
        $henkatenId = $request->get('henkatenId');
        $type = strtolower($request->get('type'));
        $lineId = $request->get('lineId');

        // initiate model
        $methodModel = new HenkatenMethod();
        $machineModel = new HenkatenMachine();
        $materialModel = new HenkatenMaterial();

        function updateHenkaten($model, $henkatenId, $troubleshoot, $approvedBy)
        {
            $result = $model->where('id', $henkatenId)
                ->update([
                    'troubleshoot' => $troubleshoot,
                    'approval' => $approvedBy,
                    'status_after' => 'running'
                ]);

            return $result;
        }

        try {
            DB::beginTransaction();

            // update henkaten table
            if ($type == 'method') {
                // insert into henkaten table
                updateHenkaten($methodModel, $henkatenId, $troubleshoot, $approvedBy);

                // check if there is any problem not solved yet
                $otherStat = HenkatenMethod::select('status')
                    ->where('status_after', null)
                    ->where('line_id', $lineId)
                    ->latest()
                    ->first();

                if (!$otherStat) {
                    // insert into line table
                    Line::where('id', $lineId)->update([
                        'status_method' => 'running'
                    ]);
                } else {
                    Line::where('id', $lineId)->update([
                        'status_method' => $otherStat->status
                    ]);
                }
            } else if ($type == 'machine') {
                // insert into henkaten table
                updateHenkaten($machineModel, $henkatenId, $troubleshoot, $approvedBy);

                // check if there is any problem not solved yet
                $otherStat = HenkatenMachine::select('status')
                    ->where('status_after', null)
                    ->where('line_id', $lineId)
                    ->latest()
                    ->first();

                if (!$otherStat) {
                    // insert into line table
                    Line::where('id', $lineId)->update([
                        'status_machine' => 'running'
                    ]);
                } else {
                    Line::where('id', $lineId)->update([
                        'status_method' => $otherStat->status
                    ]);
                }
            } else if ($type == 'material') {
                // insert into henkaten table
                updateHenkaten($materialModel, $henkatenId, $troubleshoot, $approvedBy);

                // check if there is any problem not solved yet
                $otherStat = HenkatenMaterial::select('status')
                    ->where('status_after', null)
                    ->where('line_id', $lineId)
                    ->latest()
                    ->first();

                if (!$otherStat) {
                    // insert into line table
                    Line::where('id', $lineId)->update([
                        'status_material' => 'running'
                    ]);
                } else {
                    Line::where('id', $lineId)->update([
                        'status_method' => $otherStat->status
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function selectTheme(Request $request)
    {
        // if (!$theme) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Pilih tema yang tersedia!'
        //     ]);
        // }

        // get theme name

        $parts = explode("/", $request->path());
        $customTheme = explode("-", $parts[2]);

        $theme_name = Theme::select('name')->where('id', $parts[2])->first();

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();
        if (!$pivot) {
            if (($theme_name == null)) {
                try {
                    DB::beginTransaction();
                    // insert new data if pivot table is empty
                    Pivot::create([
                        'custom_theme' => $customTheme[0],
                        'active_date' => $current_date
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => $th
                    ], 500);
                }
            } else {
                try {
                    DB::beginTransaction();

                    // insert new data if pivot table is empty
                    Pivot::create([
                        'theme_id' => $parts[2],
                        'active_date' => $current_date
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => $th
                    ], 500);
                }
            }
        } else {
            if (($theme_name == null)) {
                try {
                    DB::beginTransaction();

                    // insert new data if pivot table is empty
                    $pivot->update([
                        'custom_theme' => $customTheme[0],
                        'theme_id' => null
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => $th
                    ], 500);
                }
            } else {
                try {
                    DB::beginTransaction();

                    // insert new data if pivot table is empty
                    $pivot->update([
                        'custom_theme' => null,
                        'theme_id' => $parts[2]
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => $th
                    ], 500);
                }
            }
        }

        $custom_theme = Pivot::select('custom_theme')->where('custom_theme', $customTheme[0])->first();

        $theme_name_final = '';
        if (isset($custom_theme)) {
            $decoded_custom_theme = urldecode($custom_theme->custom_theme);
            $theme_name_final = $decoded_custom_theme;
        } elseif (isset($theme_name)) {
            $theme_name_final = $theme_name->name;
        }

        // Mengembalikan respons JSON tanpa if-else
        return response()->json([
            'status' => 'success',
            'message' => 'Tema berhasil ditambahkan!',
            'theme_id' => $parts[2],
            'theme_name' => $theme_name_final,
        ], 200);
    }

    public function selectFirstPic($id)
    {
        $pic = $id;
        if ($pic == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih karyawan yang tersedia!'
            ]);
        }

        $existingPics = Pivot::where('first_pic_id', $pic)->orWhere('second_pic_id', $pic)->first();
        if ($existingPics) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan ini sudah menjadi PIC 1 atau PIC 2.'
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'karyawan tidak terdaftar!'
            ], 404);
        }

        if (!$pivot) {
            try {
                DB::beginTransaction();

                // insert new data if pivot table is empty
                Pivot::create([
                    'first_pic_id' => $pic,
                    'active_date' => $current_date
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_pic1' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ], 500);
            }
        } else {
            try {
                DB::beginTransaction();

                $pivot->update([
                    'first_pic_id' => $pic
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ], 500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'PIC berhasil ditambahkan!',
            'name' => $employee->name,
            'photo' => $employee->photo,
            'role' => $employee->role,
            'npk' => $employee->npk
        ], 200);
    }

    public function selectSecondPic($id)
    {
        $pic = $id;
        if ($pic == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih karyawan yang tersedia!'
            ]);
        }

        $existingPics = Pivot::where('first_pic_id', $pic)->orWhere('second_pic_id', $pic)->first();
        if ($existingPics) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan ini sudah menjadi PIC 1 atau PIC 2.'
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'karyawan tidak terdaftar!'
            ], 404);
        }

        if (!$pivot) {
            try {
                DB::beginTransaction();

                // insert new data if pivot table is empty
                Pivot::create([
                    'second_pic_id' => $pic,
                    'active_date' => $current_date
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_pic2' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ], 500);
            }
        } else {
            try {
                DB::beginTransaction();

                $pivot->update([
                    'second_pic_id' => $pic
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ], 500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'PIC berhasil ditambahkan!',
            'name' => $employee->name,
            'photo' => $employee->photo,
            'role' => $employee->role,
            'npk' => $employee->npk
        ], 200);
    }
}
