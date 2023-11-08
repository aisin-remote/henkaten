<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Employee;
use App\Models\PicActive;
use App\Models\MinimumSkill;
use Illuminate\Http\Request;
use App\Models\EmployeeSkill;
use App\Models\EmployeeActive;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        // get current date
        $currentDate = Carbon::now();

        // get active employee at this period of time (today)
        
        
        return view('pages.website.employees');
    }
    
    public function employeeRegister()
    {
        return view('pages.website.registEmployee',[
            'skills' => Skill::select('name')->groupBy('name')->get()
        ]);
    }

    public function employeeStore(Request $request)
    {
        $skills = $request->skill_name;
        $levels = $request->level;
        $arraySkill = [];

        // mapping each skill
        for($i=0; $i<count($skills); $i++){
            $skillId = Skill::select('id')->where('name', $skills[$i])->where('level', $levels[$i])->first();
            if (!$skillId){
                return redirect()->back()->with('error', 'Skill atau level berlum terdaftar!');
            }
    
            array_push($arraySkill, $skillId);
        }

        $validatedData =  $request->validate([
            'name' => 'required|max:255|min:3',
            'npk' => 'required|max:6|min:6',
            'role' => 'required',
            'photo' => 'required|max:2048'
        ]);
        
        if($request->has('photo')){
            $doc = $request->file('photo');
            $docName = time() . '-' . $doc->getClientOriginalName();
            $doc->move(public_path('uploads/doc'), $docName);   

            //store doc name
            $validatedData['photo'] = $docName;
        }

        try {
            DB::beginTransaction();

            // insert into employee table
            $employee = Employee::create($validatedData);
            
            // insert into employee skill
            foreach($arraySkill as $skill) {
                EmployeeSkill::create([
                    'employee_id' => $employee->id,
                    'skill_id' => $skill->id,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Karyawan berhasil ditambah!');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Karyawan gagal ditambah!');
        }
    }

    public function employeePlanning()
    {
        return view('pages.website.planning',[
            'employees' => Employee::select('id','name')
                            ->whereIn('role',['Operator','JP'])
                            ->get(),
            'pics' =>  Employee::select('id','name')
                        ->whereNotIn('role',['Operator','JP'])
                        ->get(),
            'shifts' => Shift::select('id','name')->get(),
            'lines' => Line::select('id','name')->get()
        ]);
    }

    public function employeePlanningStore(Request $request)
    {
        $request->validate([
            'shift' => 'required',
            'line' => 'required',
            'pic_name' => 'required',
            'employee_name' => 'required',
            'active_from' => 'required',
        ]);

        $employees = $request->employee_name;
        $pics = $request->pic_name;
        $pos = $request->pos;

        // current date
        $currentDate = Carbon::parse($request->active_from);

        // get remaining day current date
        $lastDay = $currentDate->endOfWeek();
        $remainingDays = $currentDate->diffInDays($lastDay);
        
        // set end date
        $endDate = $currentDate->addDays($remainingDays);

        // get all active from date
        $startDate = EmployeeActive::select('active_from')
                        ->whereDate('active_from', '>=', Carbon::now())
                        ->first();
                        
        // if the "active_from" date isnt outside the range or the data is empty, you cant create new records
        if($startDate){
            if(Carbon::parse($request->active_from)->between(Carbon::parse($request->active_from)->startOfWeek(),$endDate)){
                return redirect()->back()->with('error', 'Planning gagal dibuat, range tanggal sudah terisi!');
            }
        }
        
        try {
            DB::beginTransaction();

                for($i=0; $i<count($employees); $i++){
                    EmployeeActive::create([
                        'employee_id' => $employees[$i],
                        'shift_id' => $request->shift,
                        'line_id' => $request->line,
                        'pos' => $pos[$i],
                        'active_from' => $request->active_from,
                        'expired_at' => $endDate
                    ]);
                }
                
                for($i=0; $i<count($pics); $i++){
                    PicActive::create([
                        'employee_id' => $pics[$i],
                        'line_id' => $request->line,
                        'active_from' => $request->active_from,
                        'expired_at' => $endDate
                    ]);
                }
                
            DB::commit();
            return redirect()->back()->with('success', 'Planning berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Planning gagal dibuat!');
        }
    }

    public function getSkillEmp(Request $request)
    {
        $skills = EmployeeSkill::with('skill')->where('employee_id', $request->employee)->get();
        if(!$skills){
            return response()->json([
                'status' => 'error',
                'message' => 'Skill tidak ditemukan'
            ],400);
        }

        return response()->json([
            'status' => 'success',
            'data' => $skills
        ],200);
    }

    public function getSkillPos(Request $request)
    {
        $skills = MinimumSkill::with('skill')
                    ->where('line_id', $request->line)
                    ->where('pos', $request->pos)
                    ->get();
        if(!$skills){
            return response()->json([
                'status' => 'error',
                'message' => 'Skill tidak ditemukan'
            ],400);
        }

        return response()->json([
            'status' => 'success',
            'data' => $skills
        ],200);
    }
}
