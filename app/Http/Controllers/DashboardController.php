<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Theme;
use App\Models\Employee;
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

        // in this page we will get all line status
        return view('pages.website.dashboard', [
            'pivot' => $pivot,
            'themes' => Theme::all(),
            'employees' => Employee::select('id', 'name')
                ->whereIn('role', ['Leader', 'JP'])
                ->get(),
            'lines' => Line::all()
        ]);
    }

    public function dashboardLine(Line $lineId)
    {
        return view('pages.website.line', [
            'line' => Line::findOrFail($lineId->id),
            'employees' => Employee::all()
        ]);
    }

    public function storeHenkaten($table, $status, $lineId, $pic, $description)
    {
        // get all data from FE
        $lineId = $lineId ? $lineId : null;
        $status = $status ? $status : null;
        $pic = $pic ? $pic : null;
        $description = $description ? $description : null;
        $table = $table ? $table : null;

        // initiate model
        $methodModel = new HenkatenMethod();
        $machineModel = new HenkatenMachine();
        $materialModel = new HenkatenMaterial();

        $currentTime = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        foreach ($shifts as $shift) {
            if ($currentTime->between($shift->time_start, $shift->time_end)) {
                $shiftId = $shift->id;
                break;
            }
        }

        function insertHenkaten($model, $shiftId, $lineId, $pic, $description)
        {
            $result = $model->create([
                'shift_id' => $shiftId,
                'line_id' => $lineId,
                'pic' => $pic,
                'henkaten_description' => $description,
                'type' => 'unplan',
                'date' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return $result;
        }

        try {
            DB::beginTransaction();

            if ($table == 'method') {
                // insert into henkaten table
                insertHenkaten($methodModel, $shiftId, $lineId, $pic, $description);

                // insert into line table
                Line::where('id', $lineId)->update([
                    'status_method' => $status
                ]);
            } else if ($table == 'machine') {
                // insert into henkaten table
                insertHenkaten($machineModel, $shiftId, $lineId, $pic, $description);

                // insert into line table
                Line::where('id', $lineId)->update([
                    'status_machine' => $status
                ]);
            } else if ($table == 'material') {
                // insert into henkaten table
                insertHenkaten($materialModel, $shiftId, $lineId, $pic, $description);

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

    public function selectTheme(Theme $theme)
    {
        if (!$theme) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih tema yang tersedia!'
            ]);
        }

        // get theme name
        $theme_name = Theme::select('name')->where('id', $theme->id)->first();

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();
        if (!$pivot) {
            try {
                DB::beginTransaction();

                // insert new data if pivot table is empty
                Pivot::create([
                    'theme_id' => $theme->id,
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

                $pivot->update([
                    'theme_id' => $theme->id
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
            'message' => 'Tema berhasil ditambahkan!',
            'theme_id' => $theme->id,
            'theme_name' => $theme_name->name,
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
