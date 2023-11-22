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
        $masterEmployees = Employee::select('id', 'name', 'npk', 'role', 'status', 'photo')
            ->get();

        $allSkills = Skill::select('id', 'name', 'level')->get();
        $nameSkills = Skill::select('name')->groupBy('name')->get();
        $empSkills = EmployeeSkill::select()->get();

        return view('pages.website.registEmployee', [
            'skills' => Skill::select('name')->groupBy('name')->get(),
            'masterEmployee' => $masterEmployees,
            'allSkills' => $allSkills,
            'empSkills' => $empSkills,
            'nameSkills' => $nameSkills
        ]);
    }

    public function employeeStore(Request $request)
    {
        $skills = $request->skill_name;
        $levels = $request->level;
        $arraySkill = [];

        // mapping each skill
        for ($i = 0; $i < count($skills); $i++) {
            $skillId = Skill::select('id')->where('name', $skills[$i])->where('level', $levels[$i])->first();
            if (!$skillId) {
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

        if ($request->has('photo')) {
            $doc = $request->file('photo');
            $docName = time() . '-' . $validatedData['name'];
            $doc->move(public_path('uploads/doc'), $docName);

            //store doc name
            $validatedData['photo'] = $docName;
        }

        try {
            DB::beginTransaction();

            // insert into employee table
            $employee = Employee::create($validatedData);

            // insert into employee skill
            foreach ($arraySkill as $skill) {
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
        // get current date
        $currentDate = Carbon::now();
        $firstDay = $currentDate->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $lastDay = $currentDate->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        // get active employee at this period of time (this week)
        $activeEmployees = EmployeeActive::with('shift')
            ->with('employee')
            ->with('line')
            ->whereBetween('active_from', [$firstDay, $lastDay])
            ->get();

        $allSkills = Skill::select('id', 'name', 'level')->get();
        $nameSkills = Skill::select('name')->groupBy('name')->get();
        $empSkills = EmployeeSkill::select()->get();

        return view('pages.website.planning', [
            'employees' => Employee::select('id', 'name')
                ->whereIn('role', ['Operator', 'JP'])
                ->get(),
            'pics' =>  Employee::select('id', 'name')
                ->whereNotIn('role', ['Operator', 'JP'])
                ->get(),
            'shifts' => Shift::select('id', 'name')->get(),
            'lines' => Line::select('id', 'name')->get(),

            'skills' => Skill::select('name')->groupBy('name')->get(),
            'activeEmployees' => $activeEmployees,
            'allSkills' => $allSkills,
            'empSkills' => $empSkills,
            'nameSkills' => $nameSkills
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
        $pic = $request->pic_name;
        $pos = $request->pos;

        // current date
        $currentDate = Carbon::parse($request->active_from);

        // get remaining day current date
        $lastDay = $currentDate->endOfWeek();
        $remainingDays = $currentDate->diffInDays($lastDay);

        // set end date
        $endDate = $currentDate->addDays($remainingDays);

        // get all active from date
        for ($i = 0; $i < count($employees); $i++) {
            $startDate = EmployeeActive::select('active_from')
                ->where('employee_id', $employees[$i])
                ->first();
                
            // if the "active_from" date isnt outside the range or the data is empty, you cant create new records
            if ($startDate) {
                if (Carbon::parse($request->active_from)->between(Carbon::parse($startDate->active_from)->startOfWeek(), $endDate)) {
                    return redirect()->back()->with('error', 'Planning gagal dibuat, karyawan (' . $employees[$i] . ') sudah pernah didaftarkan dirange waktu ini!');
                }
            }
        }

        // check if pic already exists
        $picActive = PicActive::where('employee_id', $pic)->first();
        
        try {
            DB::beginTransaction();

            for ($i = 0; $i < count($employees); $i++) {
                EmployeeActive::create([
                    'employee_id' => $employees[$i],
                    'shift_id' => $request->shift,
                    'line_id' => $request->line,
                    'pos' => $pos[$i],
                    'active_from' => $request->active_from,
                    'expired_at' => $endDate
                ]);
            }
            
            if($picActive){
                PicActive::create([
                    'employee_id' => $pic,
                    'shift_id' => $request->shift,
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

    public function getPic(Request $request)
    {
        $shift = $request->shift;
        $line = $request->line;

        if(!$shift){
            return response()->json([
                'status' => 'error',
                'mesasge' => 'belum memilih shift!'
            ]);
        }
        if(!$line){
            return response()->json([
                'status' => 'error',
                'mesasge' => 'belum memilih line!'
            ]);
        }

        $pic = PicActive::select('employee_id')
                ->where('shift_id', $shift)
                ->where('line_id', $line)
                ->first();
                
        if(!$pic){
            return response()->json([
                'status' => 'error',
                'mesasge' => 'belum memiliki pic!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'employee' => $pic->employee_id
        ]);
    }

    public function getSkillEmp(Request $request)
    {
        $skills = EmployeeSkill::with('skill')->where('employee_id', $request->employee)->get();
        if (!$skills) {
            return response()->json([
                'status' => 'error',
                'message' => 'Skill tidak ditemukan'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'data' => $skills
        ], 200);
    }

    public function getSkillPos(Request $request)
    {
        $skills = MinimumSkill::with('skill')
            ->where('line_id', $request->line)
            ->where('pos', $request->pos)
            ->get();
        if (!$skills) {
            return response()->json([
                'status' => 'error',
                'message' => 'Skill tidak ditemukan'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'data' => $skills
        ], 200);
    }

    public function employeeEdit($id)
    {
        // Mengambil data karyawan berdasarkan ID
        $employee = Employee::find($id);
        $skills = EmployeeSkill::where('employee_id', $id)->get();
        $allSkills = Skill::select('id', 'name', 'level')->get();
        $nameSkills = Skill::select('name')->groupBy('name')->get();

        // Mengirim data karyawan ke view edit
        return view('pages.website.editEmployee', compact('employee', 'skills', 'allSkills', 'nameSkills'));
    }

    public function employeeUpdate(Request $request,  $id)
    {
        $skills = $request->skill_name;
        $levels = $request->level;
        $arraySkill = [];

        // mapping each skill
        for ($i = 0; $i < count($skills); $i++) {
            $skillId = Skill::select('id')->where('name', $skills[$i])->where('level', $levels[$i])->first();
            if (!$skillId) {
                return redirect()->back()->with('error', 'Skill atau level berlum terdaftar!');
            }

            array_push($arraySkill, $skillId);
        }

        $validatedData =  $request->validate([
            'name' => 'required|max:255|min:3',
            'npk' => 'required|max:6|min:6',
            'role' => 'required',
            'photo' => 'nullable|max:2048'
        ]);

        if ($request->has('photo')) {
            $doc = $request->file('photo');
            $docName = time() . '-' . $validatedData['name'];
            $doc->move(public_path('uploads/doc'), $docName);

            //store doc name
            $validatedData['photo'] = $docName;
        }

        try {
            DB::beginTransaction();

            // insert into employee table
            $employee = Employee::findOrFail($id);
            $employee->update($validatedData);

            // insert into employee skill
            foreach ($arraySkill as $skill) {
                $employeeSkill = EmployeeSkill::where('employee_id', $employee->id)
                    ->where('skill_id', $skill->id)
                    ->first();

                if ($employeeSkill) {
                    $employeeSkill->update([
                        'employee_id' => $employee->id,
                        'skill_id' => $skill->id,
                    ]);
                } else {
                    EmployeeSkill::create([
                        'employee_id' => $employee->id,
                        'skill_id' => $skill->id,
                    ]);
                }
            }

            $existingSkills = EmployeeSkill::where('employee_id', $employee->id)->pluck('skill_id')->toArray();

            $skillsToDelete = array_diff($existingSkills, array_column($arraySkill, 'id'));

            EmployeeSkill::where('employee_id', $employee->id)->whereIn('skill_id', $skillsToDelete)->delete();

            DB::commit();
            return redirect('employee/register')->with('success', 'Karyawan berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Karyawan gagal diperbarui!');
        }
    }

    public function employeeDetail($id)
    {
        // Mengambil data karyawan berdasarkan ID
        $employee = Employee::find($id);
        $skills = EmployeeSkill::where('employee_id', $id)->get();
        $allSkills = Skill::select('id', 'name', 'level')->get();
        $nameSkills = Skill::select('name')->groupBy('name')->get();

        // Mengirim data karyawan ke view edit
        return view('pages.website.detailEmployee', compact('employee', 'skills', 'allSkills', 'nameSkills'));
    }

    public function destroy($id)
    {
        if (request()->isMethod('delete')) {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return redirect('/employee')->with('success', 'Employee deleted successfully!');
        } else {
            // Handle unsupported methods
            return response()->json(['error' => 'Method not allowed'], 405);
        }
    }

    public function destroyPlanning($id)
    {
        if (request()->isMethod('delete')) {
            $employee = EmployeeActive::findOrFail($id);
            $employee->delete();

            return redirect('/employee')->with('success', 'Employee deleted successfully!');
        } else {
            // Handle unsupported methods
            return response()->json(['error' => 'Method not allowed'], 405);
        }
    }
}
