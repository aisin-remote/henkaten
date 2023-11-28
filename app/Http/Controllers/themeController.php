<?php

namespace App\Http\Controllers;

use Route;
use App\Models\Theme;
use Illuminate\Http\Request;
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
        $theme = $request->input('repeater-group');
        
        // Extract the lowercase "name" values from each inner array
        $names = array_map('strtoupper', array_column($theme, 'name'));

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
            return redirect()->back()->with('error', 'Theme cant be same!');
        }

        foreach($names as $name){
            // error handling when theme already exists in database
            $existingTheme = Theme::whereRaw('UPPER(name) = ?', $name)->first();
            if($existingTheme){
                return redirect()->back()->with('error', 'Theme already exist!');
            }
        }

        try {
            DB::beginTransaction();

            foreach ($theme as $theme) {
                Theme::create([
                    'name' => $theme['name']
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Theme created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Theme creation failed!');
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
