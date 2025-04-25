<?php

namespace App\Http\Controllers;

use App\Models\Yell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YellController extends Controller
{
    public function index()
    {
        $yells = Yell::all();
        return view('pages.website.yel', ['yells' => $yells]);
    }

    public function regist(Request $request)
    {
        $yell = $request->input('repeater-group');
        
        // Extract the lowercase "name" values from each inner array
        $names = array_map('strtoupper', array_column($yell, 'name'));

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
            $existingYell = Yell::whereRaw('UPPER(name) = ?', $name)->first();
            if($existingYell){
                return redirect()->back()->with('error', 'Yell-yell already exist!');
            }
        }

        try {
            DB::beginTransaction();

            foreach ($yell as $yell) {
                Yell::create([
                    'name' => $yell['name']
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Yell-yell created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Yell-yell creation failed!');
        }
    }

    public function editYell(Request $request)
    {
        try {
            $old = $request->query('old');
            $new = $request->query('new');
            $column = $request->query('column'); // item_no_1, item_no_2, etc.

            if (!$old || !$new || !$column) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Parameter old, new, dan column wajib diisi.'
                ]);
            }

            DB::table('yells')
                ->where($column, $old)
                ->update([$column => $new]);

            return response()->json([
                'status' => 'success',
                'message' => "Data berhasil diupdate.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            Yell::destroy($id);

            DB::commit();
            return redirect()->back()->with('success', 'Theme deleted successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting theme!');
        }
    }
}
