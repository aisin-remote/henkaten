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
            
        return view('pages.website.registSkill',[
            'masterSkill' => $masterSkills
        ]);
    }

    public function minimumIndex()
    {
        return view('pages.website.minimumSkill', [
            'skills' => Skill::selectRaw('MAX(id) as id, name')->groupBy('name')->get(),
            'lines' => Line::all()
        ]);
    }

    public function regist(Request $request)
    {
        $skills = $request->input('repeater-group');

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

            return redirect()->back()->with('success', 'Skill berhasil ditambah!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Skill gagal ditambah!');
        }
    }

    public function minimumRegist(Request $request)
    {
        $skills = [];
        $validatedData = $request->validate([
            'skill' => 'required',
            'pos' => 'required',
            'line' => 'required',
            'level' => 'required',
        ]);

        // get skill id
        for ($i = 0; $i < count($validatedData['skill']); $i++) {
            $skillId = Skill::select('id')
                ->where('name', $validatedData['skill'][$i])
                ->where('level', $validatedData['level'][$i])
                ->first();
            array_push($skills, $skillId->id);
        }

        try {
            DB::beginTransaction();

            for ($i = 0; $i < count($validatedData['skill']); $i++) {
                MinimumSkill::create([
                    'skill_id' => $skills[$i],
                    'pos' => $request->pos[$i],
                    'line_id' => $request->line[$i],
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Minimum skill berhasil ditambah!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
