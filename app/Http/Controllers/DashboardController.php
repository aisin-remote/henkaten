<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pivot;
use App\Models\Theme;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function index()
    {
        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::with('theme')
                    ->with('firstPic')
                    ->with('secondPic')
                    ->where('active_date', $current_date)
                    ->first();

        // in this page we will get all line status
        return view('pages.website.dashboard',[
            'pivot' => $pivot,
            'themes' => Theme::all(),
            'employees' => Employee::select('id','name')
                            ->whereIn('role',['Leader','JP'])
                            ->get(),
        ]);
    }

    public function selectTheme(Request $request)
    {
        $theme = $request->theme;
        if($theme == 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih tema yang tersedia!'
            ]);
        }

        // get theme name
        $theme_name = Theme::select('name')->where('id',$theme)->first();

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();
        if(!$pivot){
            try {
                DB::beginTransaction();
                
                // insert new data if pivot table is empty
                Pivot::create([
                    'theme_id' => $theme,
                    'active_date' => $current_date
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ],500);
            }
        }else{
            try {
                DB::beginTransaction();

                $pivot->update([
                    'theme_id' => $theme
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ],500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tema berhasil ditambahkan!',
            'theme_id' => $theme,
            'theme_name' => $theme_name->name,
        ],200);
    }

    public function selectFirstPic(Request $request)
    {
        $pic = $request->pic;
        if($pic == 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih karyawan yang tersedia!'
            ]);
        }


        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();
        
        $employee = Employee::where('id', $pic)->first();
        if(!$employee){
            return response()->json([
                'status' => 'error',
                'message' => 'karyawan tidak terdaftar!'
            ],404);
        }

        if(!$pivot){
            try {
                DB::beginTransaction();
                
                // insert new data if pivot table is empty
                Pivot::create([
                    'first_pic_id' => $pic,
                    'active_date' => $current_date
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_pic1' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ],500);
            }
        }else{
            try {
                DB::beginTransaction();

                $pivot->update([
                    'first_pic_id' => $pic
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ],500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'PIC berhasil ditambahkan!',
            'name' => $employee->name,
            'photo' => $employee->photo,
            'role' => $employee->role,
            'npk' => $employee->npk
        ],200);
    }

    public function selectSecondPic(Request $request)
    {
        $pic = $request->pic;
        if($pic == 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih karyawan yang tersedia!'
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();
        
        $employee = Employee::where('id', $pic)->first();
        if(!$employee){
            return response()->json([
                'status' => 'error',
                'message' => 'karyawan tidak terdaftar!'
            ],404);
        }

        if(!$pivot){
            try {
                DB::beginTransaction();
                
                // insert new data if pivot table is empty
                Pivot::create([
                    'second_pic_id' => $pic,
                    'active_date' => $current_date
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_pic2' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ],500);
            }
        }else{
            try {
                DB::beginTransaction();

                $pivot->update([
                    'second_pic_id' => $pic
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $th
                ],500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'PIC berhasil ditambahkan!',
            'name' => $employee->name,
            'photo' => $employee->photo,
            'role' => $employee->role,
            'npk' => $employee->npk
        ],200);
    }
}
