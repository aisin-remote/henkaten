<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Skill;
use App\Models\MinimumSkill;
use Illuminate\Http\Request;
use App\Models\EmployeeSkill;
use Illuminate\Support\Facades\DB;

class skillController extends Controller
{
    public function index()
    {
        $masterSkills = Skill::select('name', DB::raw('GROUP_CONCAT(level) as levels'))
            ->groupBy('name')
            ->get();

        return view('pages.website.registSkill', [
            'masterSkill' => $masterSkills
        ]);
    }

    public function minimumIndex()
    {
        $empOrigin = auth()->user()->origin_id;
        
        return view('pages.website.minimumSkill', [
            'minimumSkills' => MinimumSkill::all(),
            'skills' => Skill::selectRaw('MAX(id) as id, name')->groupBy('name')->get(),
            'lines' => Line::where('origin_id', $empOrigin)->get()
        ]);
    }

    public function regist(Request $request)
    {
        $skills = $request->input('repeater-group');

        // Extract the lowercase "name" values from each inner array
        $names = array_map('strtoupper', array_column($skills, 'name'));

        // Count occurrences of each name
        $nameCounts = array_count_values($names);
        
        // Check for duplicates
        $duplicates = [];
        foreach ($nameCounts as $name => $count) {
            if ($count > 1) {
                $duplicates[] = $name;
            }
        }

        // Check if there are duplicates
        if (!empty($duplicates)) {
            // Handle the case where duplicates are found
            return redirect()->back()->with('error', 'Skill cant be same!');
        }

        foreach($names as $name){
            // error handling when theme already exists in database
            $existingSkill = Skill::whereRaw('UPPER(name) = ?', $name)->first();
            if($existingSkill){
                return redirect()->back()->with('error', 'Skill already exist!');
            }
        }

        try {
            DB::beginTransaction();

            foreach ($skills as $skill) {
                for ($i = 1; $i <= 5; $i++) {
                    Skill::create([
                        'name' => $skill['name'],
                        'level' => $i + 1
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Skill created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Skill creation failed!');
        }
    }

    public function minimumRegist(Request $request)
    {
        $create = null;
        $validatedData = $request->validate([
            'skill' => 'required',
            'pos' => 'required',
            'line' => 'required',
            'level' => 'required',
        ]);

        try {
            DB::beginTransaction();

            for ($i = 0; $i < count($validatedData['skill']); $i++) {
                
                // check if any data empty
                if($request->line[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input skill');
                }
                
                if($request->pos[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input pos');
                }
                
                if($request->skill[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input skill');
                }
                
                if($request->level[$i] == 0){
                    return redirect()->back()->with('warning', 'Belum input level');
                }
                
                $skill = Skill::where('name', $validatedData['skill'][$i])
                    ->where('level', $validatedData['level'][$i])
                    ->firstOrFail();

                // Check if the MinimumSkill record already exists
                $existingMinimumSkill = MinimumSkill::join('skills', 'minimum_skills.skill_id', '=', 'skills.id')
                    ->where('minimum_skills.pos', $request->pos[$i])
                    ->where('minimum_skills.line_id', $request->line[$i])
                    ->where('skills.name', $validatedData['skill'][$i])
                    ->get();

                if ($existingMinimumSkill->isEmpty()) {
                    $create = MinimumSkill::create([
                        'skill_id' => $skill->id,
                        'pos' => $request->pos[$i],
                        'line_id' => $request->line[$i],
                    ]);
                }
            }
            // Commit the transaction
            DB::commit();

            if ($create !== null) {
                return redirect()->back()->with('success', 'Minimum skill berhasil ditambah!');
            } else if($create === null) {
                return redirect()->back()->with('error', 'Data yang di input sudah ada.');
            }
        } catch (\Throwable $th) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function checkSkill(Request $request)
    {
        $line = $request->line;
        $pos = $request->pos;
        $skill = $request->skill;

        // check skill if skill is already registerd in minimum skill
        // get skill name in spesific line and pos
        $skills = MinimumSkill::with('skill')->where('line_id', $line)->where('pos', $pos)->get();
        if (!$skills) {
            return response()->json([
                'status' => 'success',
                'message' => 'skill bisa didaftarkan!'
            ], 200);
        }

        foreach ($skills as $item) {
            if ($item->skill->name == $skill) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'skill sudah terdaftar!'
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'skill bisa didaftarkan!'
                ], 200);
            }
        }
    }

    public function minimumRegistEdit($id)
    {
        $minimumSkill = MinimumSkill::find($id);
        $lines = Line::all();
        $skills = Skill::selectRaw('MAX(id) as id, name')->groupBy('name')->get();
        $skillName = Skill::all();

        return view('pages.website.editMinimumSkill', compact('minimumSkill', 'lines', 'skills', 'skillName'));
    }

    public function minimumRegistUpdate(Request $request, $id)
    {
        // Check if the MinimumSkill record already exists
        $existingMinimumSkill = MinimumSkill::join('skills', 'minimum_skills.skill_id', '=', 'skills.id')
                ->where('minimum_skills.pos', $request->pos)
                ->where('minimum_skills.line_id', $request->line)
                ->where('skills.name', $request->skill)
                ->get();

        if($existingMinimumSkill){
            return redirect('skill/minimum')->with('error', 'Data yang di input sudah ada atau sama!');
        }

        try {
            DB::beginTransaction();

            // update skill
            MinimumSkill::where('id', $id)->update([
                'skill_id' => $request->skill   ,
                'pos' => $request->pos,
                'line_id' => $request->line,
            ]);

            DB::commit();

            return redirect('skill/minimum')->with('success', 'Minimum skill berhasil diubah!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        if (request()->isMethod('delete')) {
            $employee = MinimumSkill::findOrFail($id);
            $employee->delete();

            return redirect('/employee')->with('success', 'Minimum Skill deleted successfully!');
        } else {
            // Handle unsupported methods
            return response()->json(['error' => 'Method not allowed'], 405);
        }
    }

    public function destroySkill($name)
    {
        if (request()->isMethod('delete')) {
            $employee = Skill::where('name', $name);
            // dd($employee);
            $employee->delete();

            return redirect('/employee')->with('success', 'Skill deleted successfully!');
        } else {
            // Handle unsupported methods
            return response()->json(['error' => 'Method not allowed'], 405);
        }
    }
}
