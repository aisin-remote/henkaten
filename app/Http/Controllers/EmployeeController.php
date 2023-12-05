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
        $masterEmployees = Employee::all();

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

        if($skills !== null){
            // mapping each skill
            for ($i = 0; $i < count($skills); $i++) {            // check if any data empty
                if($skills[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input skill');
                }
                
                if($levels[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input level');
                }
                
                
                $skillId = Skill::select('id')->where('name', $skills[$i])->where('level', $levels[$i])->first();
                if (!$skillId) {
                    return redirect()->back()->with('error', 'Skill atau level berlum terdaftar!');
                }
    
                array_push($arraySkill, $skillId);
            }
        }

        $validatedData =  $request->validate([
            'name' => 'required|max:255|min:3',
            'npk' => 'required|max:6|min:6',
            'role' => 'required',
            'photo' => 'required|max:3072'
        ]);

        // npk exist
        $existingNpk = Employee::where('npk', $validatedData['npk'])->first();
        if ($existingNpk){
            return redirect()->back()->with('error', 'Npk sudah terdaftar!');
        }

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

            if($skills !== null){
                // insert into employee skill
                foreach ($arraySkill as $skill) {
                    EmployeeSkill::create([
                        'employee_id' => $employee->id,
                        'skill_id' => $skill->id,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Karyawan berhasil ditambah!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function employeePlanning()
    {
        // get current date
        $currentDate = Carbon::now();
        $firstDay = $currentDate->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $lastDay = $currentDate->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        // get active employee at this period of time (this week)
        $activeEmployees = DB::table('employee_active')
                ->join('shifts', 'employee_active.shift_id', '=', 'shifts.id')
                ->join('lines', 'employee_active.line_id', '=', 'lines.id')
                ->join('employees', 'employee_active.employee_id', '=', 'employees.id')
                ->select('shifts.name as shift_name', 'shifts.id as shift_id' , 'lines.id as line_id','lines.name as line_name', 'employee_active.active_from', 'employee_active.expired_at', 'employees.name', 'employees.photo','employees.npk', 'employees.role', 'employee_active.pos', 'employees.id as employee_id')
                ->whereBetween('employee_active.active_from', [$firstDay, $lastDay])
                ->get();
    
        // Manually group by shift, line, and week
        $groupedEmployees = $activeEmployees->groupBy(function ($employee) {
            return $employee->shift_name . '|' . $employee->line_name . '|' . Carbon::parse($employee->active_from)->format('Y-m-d') . '|' . Carbon::parse($employee->expired_at)->format('Y-m-d');
        });
        
        // Convert the grouped collection to a standard array
        $groupedArray = $groupedEmployees->toArray();

        $allSkills = Skill::select('id', 'name', 'level')->get();
        $nameSkills = Skill::select('name')->groupBy('name')->get();
        $empSkills = EmployeeSkill::select()->get();

        return view('pages.website.planning', [
            'employees' => Employee::select('id', 'name')
                ->whereIn('role', ['Operator'])
                ->get(),
            'pics' =>  Employee::select('id', 'name')
                ->whereNotIn('role', ['Operator'])
                ->get(),
            'shifts' => Shift::select('id', 'name')->get(),
            'lines' => Line::select('id', 'name')->get(),

            'skills' => Skill::select('name')->groupBy('name')->get(),
            'groupedArray' => $groupedArray,
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
            'employee_id' => 'required',
            'active_from' => 'required',
        ]);
        $employees = $request->employee_id;
        $pic = $request->pic_name;
        $pos = $request->pos;

        if($pic[0] === 0){
            return redirect()->back()->with('error', 'Isi PIC!');
        }

        if($employees[0] === 0){
            return redirect()->back()->with('error', 'Isi karyawan pos 1!');
        }else if($employees[1] == '0'){
            return redirect()->back()->with('error', 'Isi karyawan pos 2!');
        }

        // count same value of input
        $nameCounts = array_count_values(array_map('strtoupper', $employees));
        
        // Check for duplicates
        $duplicates = [];
        foreach ($nameCounts as $value => $count) {
            if ($count > 1) {
                $duplicates[] = $value;
            }
        }
        
        // Check if there are duplicates
        if (!empty($duplicates)) {
            return redirect()->back()->with('error', 'Karyawan tidak boleh sama!');
        }


        // get all employee skill
        for($i = 0; $i < count($employees); $i++){
            $employeeSkills = EmployeeSkill::with(['skill','employee'])->where('employee_id', $employees[$i])->get();

            // if no skill
            if(count($employeeSkills) === 0){
                return redirect()->back()->with('error', 'Karyawan tidak memiliki skill!');
            }
            
            $minimumSkills = MinimumSkill::with('skill')
                    ->where('line_id', $request->line)
                    ->where('pos', $pos[$i])
                    ->get();
            
            // if employee skill lower than minimum skill required
            if(count($employeeSkills) < count($minimumSkills)){
                return redirect()->back()->with('error', 'Tidak memiliki semua skill yang dibutuhkan!');
            }
                
            foreach($minimumSkills as $minimumSkill){
                foreach($employeeSkills as $employeeSkill){
                    if($employeeSkill->skill->level < $minimumSkill->skill->level){
                        return redirect()->back()->with('error', 'Level skill karyawan : ' . $employeeSkill->employee->name . ' kurang dari ketentuan!');
                    }
                }
            }
        }

        // current date
        $currentDate = Carbon::parse($request->active_from);

        // get remaining day current date
        $lastDay = $currentDate->endOfWeek();
        $remainingDays = $currentDate->diffInDays($lastDay);

        // set end date
        $endDate = $currentDate->addDays($remainingDays);

        // get all active from date
        for ($i = 0; $i < count($employees); $i++) {
            $startDate = EmployeeActive::select('active_from', 'expired_at')
                ->where('employee_id', $employees[$i])
                ->first();
                
            // if the "active_from" date isnt outside the range or the data is empty, you cant create new records
            if ($startDate) {
                if (Carbon::parse($request->active_from)->between(Carbon::parse($startDate->active_from)->startOfWeek(), $startDate->expired_at)) {
                    return redirect()->back()->with('error', 'Planning gagal dibuat, karyawan (' . $employees[$i] . ') sudah pernah didaftarkan dirange waktu ini!');
                }
            }
        }
        
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
            
            PicActive::create([
                'employee_id' => $pic[0],
                'shift_id' => $request->shift,
                'line_id' => $request->line,
                'active_from' => $request->active_from,
                'expired_at' => $endDate
            ]);

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
                'message' => 'belum memilih shift!'
            ]);
        }
        if(!$line){
            return response()->json([
                'status' => 'error',
                'message' => 'belum memilih line!'
            ]);
        }

        $pic = PicActive::select('employee_id')
                ->where('shift_id', $shift)
                ->where('line_id', $line)
                ->first();
                
        if(!$pic){
            return response()->json([
                'status' => 'error',
                'message' => 'belum memiliki pic!'
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
        $line = $request->line;
        $pos = $request->pos;
        $employee = $request->employee;
        
        if(!$line){
            return response()->json([
                'status' => 'warning',
                'message' => 'Pilih line!'
            ]);
        }
        
        if(!$employee || !$employee === '0' || $employee === null){
            return response()->json([
                'status' => 'warning',
                'message' => 'Pilih karyawan!'
            ]);
        }
        
        if(!$pos || $pos === '0' || $pos === null){
            return response()->json([
                'status' => 'warning',
                'message' => 'Pilih pos!'
            ]);
        }
        
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
        
        // count same value of input
        $nameCounts = array_count_values(array_map('strtoupper', $skills));
        
        // Check for duplicates
        $duplicates = [];
        foreach ($nameCounts as $value => $count) {
            if ($count > 1) {
                $duplicates[] = $value;
            }
        }
        
        // Check if there are duplicates
        if (!empty($duplicates)) {
            return redirect()->back()->with('error', 'Skill cant be same!');
        }

        $levels = $request->level;
        $arraySkill = [];

        if($skills !== null){
            // mapping each skill
            for ($i = 0; $i < count($skills); $i++) {
                if($skills[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input skill');
                }
                
                if($levels[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input level');
                }

                $skillId = Skill::select('id')->where('name', $skills[$i])->where('level', $levels[$i])->first();
                if (!$skillId) {
                    return redirect()->back()->with('error', 'Skill atau level belum terdaftar!');
                }
    
                array_push($arraySkill, $skillId);
            }
        }

        $validatedData =  $request->validate([
            'name' => 'required|max:255|min:3',
            'npk' => 'required|max:6|min:6',
            'role' => 'required',
            'photo' => 'nullable|max:3072'
        ]);


        // get npk of user
        $currentNpk = Employee::where('id', $id)->first();
        if ($currentNpk->npk !== $validatedData['npk']){
            // npk exist
            $existingNpk = Employee::where('npk', $validatedData['npk'])->first();
            if ($existingNpk){
                return redirect()->back()->with('error', 'Npk sudah terdaftar!');
            }
        }
        

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

                if($skills !== null){
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
            }

            $existingSkills = EmployeeSkill::where('employee_id', $employee->id)->pluck('skill_id')->toArray();

            $skillsToDelete = array_diff($existingSkills, array_column($arraySkill, 'id'));

            EmployeeSkill::where('employee_id', $employee->id)->whereIn('skill_id', $skillsToDelete)->delete();

            DB::commit();
            return redirect('employee')->with('success', 'Karyawan berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
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

    public function destroyPlanning(Request $request)
    {
        try {
            DB::beginTransaction();

            // delete first employee
            EmployeeActive::where('employee_id', $request->first_id)->where('active_from', $request->active_from)->delete();
            
            // delete second employee
            EmployeeActive::where('employee_id', $request->second_id)->where('active_from', $request->active_from)->delete();

            // delete pic
            PicActive::where('shift_id', $request->shift)->where('line_id', $request->line)->delete();

            DB::commit();
            return redirect('/employee/planning')->with('success', 'Planning deleted successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect('/employee/planning')->with('error', $th->getMessage());
        }
    }
    
    public function destroyEmployee($id)
    {
        try {
            DB::beginTransaction();

            // delete first employee
            Employee::where('id', $id)->delete();

            DB::commit();
            return redirect('/employee')->with('success', 'Employee deleted successfully!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect('/employee')->with('error', $th->getMessage());
        }
    }
}
