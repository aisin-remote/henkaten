<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Shift;
use App\Models\Henkaten;
use App\Models\HenkatenMan;
use App\Models\Troubleshoot;
use Illuminate\Http\Request;
use App\Models\HenkatenMethod;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use Illuminate\Support\Facades\DB;

class HenkatenController extends Controller
{
    public function storeHenkaten(Request $request)
    {
        $currentTime = Carbon::now();
        $shifts = Shift::all();
        $shiftId = null;

        foreach ($shifts as $shift) {
            if ($currentTime->between($shift->time_start, $shift->time_end)) {
                $shiftId = $shift->id;
                break;
            }
        }

        try {
            DB::beginTransaction();

            Henkaten::create([
                '4M' => $request->type,
                'status' => $request->status,
                'shift_id' => $shiftId,
                'line_id' => $request->line,
                'category' => $request->category,
                'henkaten_management_id' => $request->henkatenManagement,
                'abnormality' => $request->abnormality,
                'date' => Carbon::now(),
                'is_done' => '0'
            ]);

            // change line status
            Line::where('id', $request->line)->update([
                'status_' . $request->type => $request->status
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function troubleshootHenkaten(Request $request)
    {
        $statusMappings = [
            'henkaten' => ['priority' => 1, 'overall' => 'henkaten'],
            'stop' => ['priority' => 2, 'overall' => 'stop'],
        ];

        try {
            DB::beginTransaction();
            if ($request->{"4M"} == 'man') {
                for ($i = 0; $i < count($request->after); $i++) {
                    if ($request->after !== '0') {
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
                    return redirect()->back()->with('success', 'Data berhasil disimpan!');
                }

                // Leveling priority
                foreach ($otherStats as $otherStat) {
                    if (isset($statusMappings[$otherStat->status])) {
                        $priority = $statusMappings[$otherStat->status]['priority'];

                        // If the priority is 2 (which is the biggest priority) we can immediately break the loop
                        if ($priority === 2) {
                            // Insert into line table
                            Line::where('id', $request->line)->update([
                                'status_' . $request->{"4M"} => $otherStat->status
                            ]);

                            DB::commit();
                            return redirect()->back()->with('success', 'Data berhasil disimpan!');
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }
    }

    
    public function troubleShootApproval(Request $request)
    {
        try {
            DB::beginTransaction();

            // change approver and is_done status
            Henkaten::where('id', $request->henkaten_id)->update([
                'is_done' => '1',
                'approver' => auth()->user()->name
            ]);

            // change line status if status before is 'stop'
            if($request->status){
                Line::where('id', $request->line)->update([
                    'status_' . $request->{"4M"} => 'running'
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Berhasil diapprove!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal diapprove!');
        }
        
    }
}
