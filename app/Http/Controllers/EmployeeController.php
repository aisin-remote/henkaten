<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PicActive;
use App\Models\Attendance;
use App\Models\MinimumSkill;
use Illuminate\Http\Request;
use App\Models\EmployeeSkill;
use App\Models\EmployeeActive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;
        $masterEmployees = Employee::where('origin_id', $empOrigin)->paginate(10);

        // Compress and update photo URLs for each employee
        // foreach ($masterEmployees as $employee) {
        //     $employee->compressed_photo_url = $this->compressAndStorePhoto($employee->photo);
        // }

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

    private function compressAndStorePhoto($filename)
    {
        // Define storage paths
        $compressedPath = 'compressed-photos/';
        $originalPath = public_path('uploads/doc') . DIRECTORY_SEPARATOR . $filename;

        // Read the first few bytes to determine the image format
        $imageHeaders = file_get_contents($originalPath, false, null, 0, 10);
        $imageFormat = finfo_buffer(finfo_open(), $imageHeaders, FILEINFO_MIME_TYPE);

        // Compress the image based on its format
        switch ($imageFormat) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($originalPath);
                imagejpeg($image, public_path($compressedPath . $filename), 5); // Adjust quality as needed
                break;
            case 'image/png':
                $image = imagecreatefrompng($originalPath);
                imagepng($image, public_path($compressedPath . $filename), 9); // Adjust compression level as needed
                break;
            // Add more cases for other image formats if needed
            default:
                // Unsupported image format, handle accordingly
                return null;
        }

        // Return the URL to the compressed photo
        return Storage::url($compressedPath . $filename);
    }

    public function attendance()
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;
        
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        
        // get shift
        $shift = Shift::where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime)->first();
        
        $activeEmployees = EmployeeActive::with('shift')
            ->with('employee')
            ->with('pos')
            ->with('line')
            ->where('active_from', '<=', $currentDate)
            ->where('expired_at', '>=', $currentDate)
            ->whereHas('shift', function ($query) use ($currentTime) {
                $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
            })
            ->whereHas('employee', function($query) use ($empOrigin){
                $query->where('origin_id', $empOrigin);
            })
            ->get();

            $activeEmployees = $activeEmployees->groupBy('line_id');
            
            // get line 
            $lines = Line::select('name','id')->where('origin_id', $empOrigin)->get();
            
        return view('pages.website.attendance', [
            'employees' => $activeEmployees,
            'shift' => $shift,
            'lines' => $lines,
        ]);
    }

    public function storeAttendance(Request $request)
    {
        $npk = $request->npk;
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        // get shift
        $shift = Shift::where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime)->first();
        
        // cek if employee exist
        $employee = Employee::where('npk', $npk)->first();
        if (!$employee){
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak terdaftar'
            ]);
        }
        
        // cek if employee already planned
        $employeePlanned = EmployeeActive::with('employee')
            ->whereHas('employee', function ($query) use ($npk){
                $query->where('npk', $npk);    
            })
            ->first();
        if (!$employeePlanned){
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan belum masuk planning!'
            ]);
        }

        $activeEmployee = EmployeeActive::with('shift')
            ->with('employee')
            ->with('pos')
            ->where('active_from', '<=', $currentDate)
            ->where('expired_at', '>=', $currentDate)
            ->whereHas('shift', function ($query) use ($currentTime) {
                $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
            })
            ->whereHas('employee', function ($query) use ($npk){
                $query->where('npk', $npk);    
            })
            ->first();
        if(!$activeEmployee){
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan npk ' . $npk . ' bukan ' . $shift->name . '!'
            ]);
        }

        $attendance = Attendance::where('employee_active_id', $activeEmployee->id)
                    ->where('created_at', 'LIKE' , $currentDate . '%')
                    ->first();
        if($attendance){
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan npk ' . $npk . ' sudah absen!'
            ]);
        }

        try {
            DB::beginTransaction();

            // insert to attendance table
            Attendance::create([
                'employee_active_id' => $activeEmployee->id,
                'time_in' => Carbon::now()->format('H:i:s'),
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data karyawan sudah tersimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function employeeStore(Request $request)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;
        
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
            'photo' => 'required|max:3072',
            'origin_id' => 'required'
        ]);

        // set origin id for new employee
        $validated['origin_id'] = $empOrigin;

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
        // get origin
        $empOrigin = auth()->user()->origin_id;
        
        // get current date
        $currentDate = Carbon::now();
        $firstDay = $currentDate->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $lastDay = $currentDate->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        // get active employee at this period of time (this week)
        $activeEmployees = DB::table('employee_active')
                ->join('positions', 'employee_active.pos_id', '=', 'positions.id')
                ->join('shifts', 'employee_active.shift_id', '=', 'shifts.id')
                ->join('lines', 'employee_active.line_id', '=', 'lines.id')
                ->join('origins', 'lines.origin_id', '=', 'origins.id')
                ->join('employees', 'employee_active.employee_id', '=', 'employees.id')
                ->select('shifts.name as shift_name', 'shifts.id as shift_id' , 'lines.id as line_id','lines.name as line_name', 'employee_active.active_from', 'employee_active.expired_at', 'employees.name', 'employees.photo','employees.npk', 'employees.role', 'employees.id as employee_id', 'positions.pos')
                ->where(function ($query) use ($empOrigin) {
                    $query->where('lines.origin_id', $empOrigin);
                })
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
            'operators' => Employee::select('id', 'name')
                ->whereIn('role', ['Operator'])
                ->where('origin_id', $empOrigin)
                ->get(),
            'pics' =>  Employee::select('id', 'name')
                ->whereNotIn('role', ['Operator'])
                ->where('origin_id', $empOrigin)
                ->get(),
            'shifts' => Shift::select('id', 'name')->get(),
            'lines' => Line::select('id', 'name')->where('origin_id', $empOrigin)->get(),
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
            // 'pic_name' => 'required',
            'employee_id' => 'required',
            'active_from' => 'required',
        ]);
        
        $employees = $request->employee_id;
        $pic = $request->pic_name;
        $pos = $request->pos;

        // get line name
        $lineName = Line::select('name')->where('id', $request->line)->first();

        // if($pic[0] === 0){
        //     return redirect()->back()->with('error', 'Isi PIC!');
        // }

        if(auth()->user()->origin->name !== 'ELECTRIC'){
            if($employees[0] === 0 && $employees[1] == '0'){
                return redirect()->back()->with('error', 'Pos tidak boleh kosong!');
            }
        }else{
            if($lineName == 'ASAN01' || $lineName == 'ASAN02'){
                if($employees[0] === 0){
                    return redirect()->back()->with('error', 'Isi karyawan pos 1!');
                }else if($employees[1] == '0'){
                    return redirect()->back()->with('error', 'Isi karyawan pos 2!');
                }else if($employees[2] == '0'){
                    return redirect()->back()->with('error', 'Isi karyawan pos 3!');
                }else if($employees[3] == '0'){
                    return redirect()->back()->with('error', 'Isi karyawan pos 4!');
                }else if($employees[4] == '0'){
                    return redirect()->back()->with('error', 'Isi karyawan pos 5!');
                }else if($employees[5] == '0'){
                    return redirect()->back()->with('error', 'Isi karyawan pos 6!');
                }
            }else{
                if($employees[0] === 0){
                    return redirect()->back()->with('error', 'Isi karyawan pos 1!');
                }
            }
        }

        // count same value of input
        $nameCounts = array_count_values(array_map('strtoupper', $employees));
        
        // Check for duplicates
        $duplicates = [];
        foreach ($nameCounts as $value => $count) {
            if ($count > 1 && $value !== 0) {
                $duplicates[] = $value;
            }
        }
        
        // Check if there are duplicates
        if (!empty($duplicates)) {
            return redirect()->back()->with('error', 'Karyawan tidak boleh sama!');
        }

        // filter employees
        $employees =  array_filter($employees, function($item) {
            return $item !== '0' && $item !== 0;
        });

        // get all employee skill
        foreach ($employees as $key => $employeeId) {
            dd($employees);
            // Retrieve the employee skills that match the minimum skills required for the position
            $employeeSkills = EmployeeSkill::with(['skill', 'employee'])
                                ->where('employee_id', $employeeId)
                                ->whereIn('skill_id', function($query) use ($request, $pos, $key) {
                                    $query->select('skill_id')
                                        ->from('minimum_skills')
                                        ->where('line_id', $request->line)
                                        ->where('pos', $pos[$key]);
                                })
                                ->get();
        
            // if no matching skill found
            if ($employeeSkills->isEmpty()) {
                return redirect()->back()->with('error', 'Karyawan tidak memiliki semua level skill yang memenuhi persyaratan minimum untuk posisi yang ditentukan!');
            }
        
            // Check if employee has all the minimum required skills for the position
            foreach($employeeSkills as $employeeSkill){
                $minimumSkill = MinimumSkill::where('line_id', $request->line)
                                            ->where('pos', $pos[$key])
                                            ->where('skill_id', $employeeSkill->skill_id)
                                            ->first();
        
                // If the employee's skill level is lower than required, return an error
                if ($employeeSkill->level < $minimumSkill->level) {
                    return redirect()->back()->with('error', 'Level skill (' . $employeeSkill->skill->name . ') karyawan : ' . $employeeSkill->employee->name . ' kurang dari ketentuan!');
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
                ->where('employee_id',$employeeId)
                ->whereBetween('active_from', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])
                ->first();
                            
            // if the "active_from" date isnt outside the range or the data is empty, you cant create new records
            if ($startDate) {
                if (Carbon::parse($request->active_from)->between(Carbon::parse($startDate->active_from)->startOfWeek(), $startDate->expired_at)) {
                    return redirect()->back()->with('error', 'Planning gagal dibuat, karyawan (' . $employeeId . ') sudah pernah didaftarkan dirange waktu ini!');
                }
            }
        }
        
        try {
            DB::beginTransaction();
            foreach ($employees as $key => $employeeId) {
                $positionId = Position::select('id')
                                    ->where('line_id', $request->line)
                                    ->where('pos', $pos[$key])
                                    ->first();
                                    
                EmployeeActive::create([
                    'employee_id' => $employeeId,
                    'shift_id' => $request->shift,
                    'line_id' => $request->line,
                    'pos_id' => $positionId->id,
                    'active_from' => $request->active_from,
                    'expired_at' => $endDate
                ]);
            }
            
            if($pic[0] !== "0"){
                PicActive::create([
                    'employee_id' => $pic[0],
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
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getEmployees(Request $request)
    {
        $line = $request->line;

        // get total employee in spesific line
        $total = Line::select('total_emp')->where('name', $line)->first();
        if ($total->total_emp == null || $total->total_emp == 0 || !$total){
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah karyawan belum disetup pada line ' . $line . ' harap hubungi ITD!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'total' => $total->total_emp
        ]);
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

    public function getSkill(Request $request)
    {
        $employeeId = $request->employeeId;

        $skills = EmployeeSkill::with('skill')->where('employee_id', $employeeId)->get();
        
        // get xAxis (skill Name)
        $skillsName = $skills->pluck('skill.name');
        $skillsLevel = $skills->pluck('skill.level');
    
        return response()->json([
            'status' => 'success',
            'x' => $skillsName,
            'y' => $skillsLevel 
        ]);
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

            for($i = 0; $i < count($request->employees_id); $i++){
                // delete employee
                EmployeeActive::where('employee_id', $request->employees_id[$i])->where('active_from', $request->active_from)->delete();
            }

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
