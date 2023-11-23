<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Route;
use Illuminate\Support\Facades\DB;

class themeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('pages.website.theme', ['themes' => $themes]);
    }

    public function regist(Request $request)
    {
        // dd($request);
        $theme = $request->input('repeater-group');

        try {
            DB::beginTransaction();

            foreach ($theme as $theme) {
                for ($i = 1; $i <= 1; $i++) {
                    Theme::create([
                        'name' => $theme['name']
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Theme berhasil ditambah!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Theme gagal ditambah!');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            Theme::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Theme deleted successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting theme!');
        }
    }
}
