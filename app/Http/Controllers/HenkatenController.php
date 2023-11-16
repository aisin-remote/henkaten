<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Shift;
use App\Models\HenkatenMan;
use Illuminate\Http\Request;
use App\Models\HenkatenMethod;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use Illuminate\Support\Facades\DB;

class HenkatenController extends Controller
{
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

    public function storeManHenkaten($before, $after, $status, $lineId, $problem, $description)
    {
        // map employee before and after
        $employeesBefore = explode(',', $before);
        $employeesAfter = explode(',', $after);

        $flag = 2;
        foreach ($employeesAfter as $employee){
            if ($employee == '0'){
                $flag--;
            }
        }
        
        // if employee after is empty
        if($flag == 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Masukkan karyawan pengganti!'
            ]);
        }

        $currentTime = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        foreach ($shifts as $shift) {
            if ($currentTime->between($shift->time_start, $shift->time_end)) {
                $shiftId = $shift->id;
                break;
            }
        }
        
        // insert into henkaten man table
        try {
            DB::beginTransaction();
            
            for($i= 0; $i<2; $i++) {
                if($employeesAfter[$i] !== '0' ){
                    HenkatenMan::create([
                        'employee_before_id' => $employeesBefore[$i],
                        'employee_after_id' => $employeesAfter[$i],
                        'shift_id' => $shiftId,
                        'line_id' => $lineId,
                        'status' => $status,
                        'henkaten_problem' => $problem,
                        'henkaten_description' => $description,
                        'date' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                }
            }

            // insert into line table
            Line::where('id', $lineId)->update([
                'status_man' => $status
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan!'
            ],200);
        } catch (\Throwable $th) {
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

        // get current status
        function getStatus($model, $henkatenId)
        {
            $result = $model->select('status')
                        ->where('id', $henkatenId)
                        ->first();
            
            return $result;
        }

        // update status after if status before is 'stop'
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
        
        // update if status before is 'hankaten'
        function updateHenkaten2($model, $henkatenId, $troubleshoot, $approvedBy)
        {
            $result = $model->where('id', $henkatenId)
                ->update([
                    'troubleshoot' => $troubleshoot,
                    'approval' => $approvedBy,
                ]);

            return $result;
        }

        try {
            DB::beginTransaction();

            // update henkaten table
            if ($type == 'method') {

                if(getStatus($methodModel, $henkatenId)->status == 'stop'){
                    // insert into henkaten table
                    updateHenkaten($methodModel, $henkatenId, $troubleshoot, $approvedBy);

                    // check if there is any problem not solved yet (stop content only)
                    $otherStat = HenkatenMethod::select('status')
                        ->where('troubleshoot', 'Belum ditangani')
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
                }else{
                    updateHenkaten2($methodModel, $henkatenId, $troubleshoot, $approvedBy);
                }
            } else if ($type == 'machine') {

                if(getStatus($machineModel, $henkatenId)->status == 'stop'){
                    // insert into henkaten table
                    updateHenkaten($machineModel, $henkatenId, $troubleshoot, $approvedBy);

                    // check if there is any problem not solved yet
                    $otherStat = HenkatenMachine::select('status')
                        ->where('troubleshoot', 'Belum ditangani')
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
                }else{
                    updateHenkaten2($methodModel, $henkatenId, $troubleshoot, $approvedBy);
                }
            } else if ($type == 'material') {

                if(getStatus($materialModel, $henkatenId)->status == 'stop'){
                    // insert into henkaten table
                    updateHenkaten($materialModel, $henkatenId, $troubleshoot, $approvedBy);

                    // check if there is any problem not solved yet
                    $otherStat = HenkatenMaterial::select('status')
                        ->where('troubleshoot', 'Belum ditangani')
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
                }else{
                    updateHenkaten2($methodModel, $henkatenId, $troubleshoot, $approvedBy);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
