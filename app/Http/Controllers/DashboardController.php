<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Line;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Theme;
use App\Models\Approval;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Henkaten;
use App\Models\Position;
use App\Models\PicActive;
use App\Models\HenkatenMan;
use Illuminate\Support\Str;
use App\Models\Troubleshoot;
use Illuminate\Http\Request;
use App\Models\EmployeeActive;
use App\Models\HenkatenMethod;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use App\Models\HenkatenManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function pushData($is_updated){
        // connection to pusher
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            '8ee9e8a15df964407aec',
            '36cee438943f3d49da89',
            '1741472',
            $options
        );

        // sending data
        $result = $pusher->trigger('henkaten' , 'DashboardUpdated', $is_updated);

        return $result;
    }
    
    public function index()
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        // get current pivot
        $currentTime = Carbon::now()->format('H:i:s');
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::with('theme')
            ->with('firstPic')
            ->with('secondPic')
            ->where('active_date', $current_date)
            ->where('origin_id', $empOrigin)
            ->first();

        // get henkaten where status still active
        $activeProblems = Henkaten::with(['shift', 'line.origin'])
            ->where(function ($query) use ($empOrigin, $currentTime, $current_date) {
                $query
                    ->whereHas('line', function ($q) use ($empOrigin) {
                        $q->where('origin_id', $empOrigin);
                    })
                    ->whereHas('shift', function ($q) use ($currentTime) {
                        $q->where(function ($subQuery) use ($currentTime) {
                            $subQuery->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
                        });
                    })
                    ->where('date', 'LIKE', $current_date . '%')
                    ->where('status', 'henkaten');
            })
            ->orWhere(function ($query) {
                $query->where('status', 'stop')->where('is_done', '0');
            })
            ->get();

        // in this page we will get all line status
        return view('pages.website.dashboard', [
            'pivot' => $pivot,
            'themes' => Theme::all(),
            'employees' => Employee::select('id', 'name')
                ->where('origin_id', $empOrigin)
                ->whereIn('role', ['Leader', 'JP'])
                ->get(),
            'lines' => Line::where('origin_id', $empOrigin)->get(),
            'histories' => $activeProblems,
        ]);
    }

    public function indexLine()
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        // in this page we will get all line status
        return view('pages.website.lineDashboard', [
            'lines' => Line::where('origin_id', $empOrigin)->get(),
        ]);
    }

    public function dashboardLine(Line $lineId)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        // get user role
        $role = auth()->user()->role;

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        // get all history
        $histories = Approval::with(['henkaten.troubleshoot.employee', 'henkaten.henkatenManagement'])
            ->whereHas('henkaten', function ($query) use ($lineId) {
                $query->where('line_id', $lineId->id);
            })
            ->get();

        // get man power at spesific line and range of time
        $activeEmployees = EmployeeActive::with('shift')
            ->with('employee')
            ->with('pos')
            ->where('active_from', '<=', $currentDate)
            ->where('expired_at', '>=', $currentDate)
            ->where('line_id', $lineId->id)
            ->whereHas('shift', function ($query) use ($currentTime) {
                $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
            })
            ->get();

        // get active pic
        $activePic = PicActive::with('shift')
            ->with('employee')
            ->where('active_from', '<=', $currentDate)
            ->where('expired_at', '>=', $currentDate)
            ->where('line_id', $lineId->id)
            ->whereHas('shift', function ($query) use ($currentTime) {
                $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
            })
            ->first();

        // get man henkaten
        $manHenkaten = Troubleshoot::with(['henkaten.shift', 'manAfter', 'manBefore'])
            ->whereHas('henkaten', function ($query) use ($lineId, $currentDate, $currentTime) {
                $query
                    ->where('date', 'LIKE', $currentDate . '%')
                    ->where('line_id', $lineId->id)
                    ->whereHas('shift', function ($subQuery) use ($currentTime) {
                        $subQuery->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
                    });
            })
            ->get();

        $attendance = Attendance::whereDate('created_at', $currentDate)
            ->first();

        return view('pages.website.line', [
            'line' => Line::findOrFail($lineId->id),
            'lineMap' => Line::where('id', $lineId->id)->first(),
            'employees' => Employee::doesntHave('employeeActive')
                ->where('origin_id', $empOrigin)
                ->get(),
            'activeEmployees' => $activeEmployees,
            'activePic' => $activePic,
            'histories' => $histories,
            'manHenkaten' => $manHenkaten,
            'attendance' => $attendance,
            'henkatenManagements' => HenkatenManagement::all(),
        ]);
    }

    public function updateLineStatus(Line $lineId, Request $request)
    {
        $onOffSwitch = $request->onOffSwitch;

        $line = Line::findOrFail($lineId->id);

        $line->update([
            'status_man' => $onOffSwitch,
            'status_method' => $onOffSwitch,
            'status_machine' => $onOffSwitch,
            'status_material' => $onOffSwitch,
        ]);

        // get origin id
        $empOrigin = auth()->user()->origin_id;

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        // get all history
        $histories = Henkaten::with(['troubleshoot.employee', 'henkatenManagement'])
            ->where('line_id', $lineId->id)
            ->get();

        // get man power at spesific line and range of time
        $activeEmployees = EmployeeActive::with('shift')
            ->with('employee')
            ->with('pos')
            ->where('active_from', '<=', $currentDate)
            ->where('expired_at', '>=', $currentDate)
            ->where('line_id', $lineId->id)
            ->whereHas('shift', function ($query) use ($currentTime) {
                $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
            })
            ->get();

        // get active pic
        $activePic = PicActive::with('shift')
            ->with('employee')
            ->where('active_from', '<=', $currentDate)
            ->where('expired_at', '>=', $currentDate)
            ->where('line_id', $lineId->id)
            ->whereHas('shift', function ($query) use ($currentTime) {
                $query->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
            })
            ->first();

        // get man henkaten
        $manHenkaten = Troubleshoot::with(['henkaten.shift', 'manAfter', 'manBefore'])
            ->whereHas('henkaten', function ($query) use ($lineId, $currentDate, $currentTime) {
                $query
                    ->where('date', 'LIKE', $currentDate . '%')
                    ->where('line_id', $lineId->id)
                    ->whereHas('shift', function ($subQuery) use ($currentTime) {
                        $subQuery->where('time_start', '<=', $currentTime)->where('time_end', '>=', $currentTime);
                    });
            })
            ->get();

        // push to websocket
        $this->pushData(true);

        return view('pages.website.line', [
            'line' => Line::findOrFail($lineId->id),
            'lineMap' => Line::where('id', $lineId->id)->first(),
            'employees' => Employee::doesntHave('employeeActive')
                ->where('origin_id', $empOrigin)
                ->get(),
            'activeEmployees' => $activeEmployees,
            'activePic' => $activePic,
            'histories' => $histories,
            'manHenkaten' => $manHenkaten,
            'henkatenManagements' => HenkatenManagement::all(),
        ]);
    }

    public function selectTheme(Request $request)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        // get theme name
        $parts = explode('/', $request->path());
        $customTheme = explode('-', $parts[2]);

        $theme_name = Theme::select('name')
            ->where('id', $parts[2])
            ->first();

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();
        if (!$pivot) {
            if ($theme_name == null) {
                try {
                    DB::beginTransaction();
                    // insert new data if pivot table is empty
                    Pivot::create([
                        'origin_id' => $empOrigin,
                        'custom_theme' => urldecode($customTheme[0]),
                        'active_date' => $current_date,
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => $th,
                        ],
                        500,
                    );
                }
            } else {
                try {
                    DB::beginTransaction();

                    // insert new data if pivot table is empty
                    Pivot::create([
                        'origin_id' => $empOrigin,
                        'theme_id' => $parts[2],
                        'active_date' => $current_date,
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => $th,
                        ],
                        500,
                    );
                }
            }
        } else {
            if ($theme_name == null) {
                try {
                    DB::beginTransaction();

                    // insert new data if pivot table is empty
                    $pivot->update([
                        'custom_theme' => urldecode($customTheme[0]),
                        'theme_id' => null,
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => $th,
                        ],
                        500,
                    );
                }
            } else {
                try {
                    DB::beginTransaction();

                    // insert new data if pivot table is empty
                    $pivot->update([
                        'custom_theme' => null,
                        'theme_id' => $parts[2],
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => $th,
                        ],
                        500,
                    );
                }
            }
        }

        $custom_theme = Pivot::select('custom_theme')
            ->where('custom_theme', urldecode($customTheme[0]))
            ->first();

        $theme_name_final = '';
        if (isset($custom_theme)) {
            $decoded_custom_theme = $custom_theme->custom_theme;
            $theme_name_final = $decoded_custom_theme;
        } elseif (isset($theme_name)) {
            $theme_name_final = $theme_name->name;
        }

        // push to websocket
        $this->pushData(true);

        // Mengembalikan respons JSON tanpa if-else
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Tema berhasil ditambahkan!',
                'theme_id' => $parts[2],
                'theme_name' => $theme_name_final,
            ],
            200,
        );
    }

    public function selectFirstPic($id)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        $pic = $id;
        if ($pic == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih karyawan yang tersedia!',
            ]);
        }

        $existingPics = Pivot::where(function ($query) use ($pic) {
            $query->where('first_pic_id', $pic)->orWhere('second_pic_id', $pic);
        })
            ->whereDate('active_date', '=', now()->toDateString()) // Menggunakan toDateString() untuk mendapatkan tanggal saja
            ->first();

        if ($existingPics) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan ini sudah menjadi PIC 1 atau PIC 2.',
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'karyawan tidak terdaftar!',
                ],
                404,
            );
        }

        if (!$pivot) {
            try {
                DB::beginTransaction();

                // insert new data if pivot table is empty
                Pivot::create([
                    'origin_id' => $empOrigin,
                    'first_pic_id' => $pic,
                    'active_date' => $current_date,
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_pic1' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $th,
                    ],
                    500,
                );
            }
        } else {
            try {
                DB::beginTransaction();

                $pivot->update([
                    'first_pic_id' => $pic,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $th,
                    ],
                    500,
                );
            }
        }

        // push to websocket
        $this->pushData(true);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'PIC berhasil ditambahkan!',
                'name' => $employee->name,
                'photo' => $employee->photo,
                'role' => $employee->role,
                'npk' => $employee->npk,
            ],
            200,
        );
    }

    public function selectSecondPic($id)
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        $pic = $id;
        if ($pic == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pilih karyawan yang tersedia!',
            ]);
        }

        $existingPics = Pivot::where(function ($query) use ($pic) {
            $query->where('first_pic_id', $pic)->orWhere('second_pic_id', $pic);
        })
            ->whereDate('active_date', '=', now()->toDateString()) // Menggunakan toDateString() untuk mendapatkan tanggal saja
            ->first();

        if ($existingPics) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan ini sudah menjadi PIC 1 atau PIC 2.',
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'karyawan tidak terdaftar!',
                ],
                404,
            );
        }

        if (!$pivot) {
            try {
                DB::beginTransaction();

                // insert new data if pivot table is empty
                Pivot::create([
                    'origin_id' => $empOrigin,
                    'second_pic_id' => $pic,
                    'active_date' => $current_date,
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_pic2' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $th,
                    ],
                    500,
                );
            }
        } else {
            try {
                DB::beginTransaction();

                $pivot->update([
                    'second_pic_id' => $pic,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $th,
                    ],
                    500,
                );
            }
        }

        // push to websocket
        $this->pushData(true);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'PIC berhasil ditambahkan!',
                'name' => $employee->name,
                'photo' => $employee->photo,
                'role' => $employee->role,
                'npk' => $employee->npk,
            ],
            200,
        );
    }
}
