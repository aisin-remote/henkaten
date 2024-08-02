<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Line;
use App\Models\Pivot;
use App\Models\Shift;
use App\Models\Theme;
use App\Models\Origin;
use App\Models\Approval;
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
use PhpMqtt\Client\MqttClient;
use App\Models\HenkatenMachine;
use App\Models\HenkatenMaterial;
use App\Models\HenkatenManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use PhpMqtt\Client\ConnectionSettings;

class DashboardController extends Controller
{
    public function mqttConnect($topic, $message)
    {
        $server   = '172.18.3.70';
        $port     = 1883;
        $clientId = '1234';
        // $username = 'fabian';
        // $password = '1234';
        $clean_session = false;
        $mqtt_version = MqttClient::MQTT_3_1_1;

        $connectionSettings = (new ConnectionSettings())
            // ->setUsername($username)
            // ->setPassword($password)
            ->setKeepAliveInterval(600)
            ->setConnectTimeout(10)
            ->setLastWillTopic('test')
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(1);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        try {
            $mqtt->connect($connectionSettings, $clean_session);

            $mqtt->publish(
                // topic
                $topic,
                // payload
                json_encode($message),
                // qos
                0,
                // retain
                false
            );
            sleep(1);
        } catch (\Exception $e) {
            // Handle the exception appropriately
            echo "Exception: " . $e->getMessage() . "\n";
        } finally {
            $mqtt->disconnect();
        }
    }
    
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

        $shifts = [
            'Non Shift' => ['start' => '07:15:00', 'end' => '16:20:00'],
            'Shift 1' => ['start' => '06:00:00', 'end' => '14:15:00'],
            'Shift 2' => ['start' => '14:16:00', 'end' => '22:15:00'],
            'Shift 3' => ['start' => '22:16:00', 'end' => '23:59:59'], // End of the first day
            'Shift 3' => ['start' => '00:00:00', 'end' => '06:00:00'], // Beginning of the second day
        ];
        
        // Initialize current shifts
        $currentShifts = [];

        // Determine the current shifts
        foreach ($shifts as $shiftName => $shiftTimes) {
            $startTime = $shiftTimes['start'];
            $endTime = $shiftTimes['end'];
            
            if ($startTime > $endTime) { // Shift spans midnight
                if (($currentTime >= $startTime && $currentTime <= '23:59:59') || ($currentTime >= '00:00:00' && $currentTime <= $endTime)) {
                    $currentShifts[] = $shiftName;
                }
            } else { // Regular shift within the same day
                if ($currentTime >= $startTime && $currentTime <= $endTime) {
                    $currentShifts[] = $shiftName;
                }
            }
        }

        // get active employee
        $activeEmployees = EmployeeActive::with(['shift', 'employee', 'pos'])
                    ->where('active_from', '<=', Carbon::now())
                    ->where('expired_at', '>=', Carbon::now())
                    ->whereHas('shift', function ($query) use ($currentShifts) {
                        $query->whereIn('name', $currentShifts);
                    })
                    ->whereHas('employee', function($query) use ($empOrigin){
                        $query->where('origin_id', $empOrigin);
                    })
                    ->count();

        // get henkaten where status still active
        $activeProblems = Henkaten::with(['shift', 'line.origin'])
            ->where(function ($query) use ($empOrigin, $currentTime, $current_date) {
                    $query->whereHas('line', function ($q) use ($empOrigin) {
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
            ->orWhere(function ($query) use ($empOrigin) {
                $query->where('status', 'stop')->where('is_done', '0')->whereHas('line', function ($q) use ($empOrigin) {
                    $q->where('origin_id', $empOrigin);
                });
            })
            ->take(2)
            ->get();

        // in this page we will get all line status
        return view('pages.website.dashboard', [
            'pivot' => $pivot,
            'activeEmployees' => $activeEmployees,
            'themes' => Theme::all(),
            'employees' => Employee::select('id', 'name')
                ->where('origin_id', $empOrigin)
                ->whereIn('role', ['Leader', 'JP'])
                ->get(),
            'supervisors' => Employee::select('id', 'name')
                ->where('origin_id', $empOrigin)
                ->where('role', 'SPV')
                ->get(),
            'lines' => Line::where('origin_id', $empOrigin)->get(),
            'histories' => $activeProblems,
            'lineGroups' => Origin::where('id', $empOrigin)->pluck('name')->first()
        ]);
    }

    public function indexLine()
    {
        // get origin id
        $empOrigin = auth()->user()->origin_id;

        // in this page we will get all line status
        return view('pages.website.lineDashboard', [
            'lines' => Line::where('origin_id', $empOrigin)->get(),
            'lineGroups' => Origin::where('id', $empOrigin)->pluck('name')->first()
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
                ->whereHas('henkaten', function ($query) use ($lineId, $currentDate) {
                    $query->where(function ($q) use ($lineId,  $currentDate) {
                        $q->where('line_id', $lineId->id)
                        ->where('is_done', '0')
                        ->orWhere(function ($q2) use ($lineId, $currentDate) {
                            $q2->where('line_id', $lineId->id)
                                ->whereDate('date', $currentDate);
                        });
                    });
                })
                ->latest()
                ->get();


        // get man power at spesific line and range of time
        $shifts = [
            'Non Shift' => ['start' => '07:15:00', 'end' => '16:20:00'],
            'Shift 1' => ['start' => '06:00:00', 'end' => '14:15:00'],
            'Shift 1 Long' => ['start' => '06:00:00', 'end' => '18:00:00'],
            'Shift 2' => ['start' => '14:16:00', 'end' => '22:15:00'],
            'Shift 3' => ['start' => '22:16:00', 'end' => '23:59:59'], // End of the first day
            'Shift 3' => ['start' => '00:00:00', 'end' => '06:00:00'], // Beginning of the second day
        ];
        
        // Initialize current shift
        $currentShift = null;
        
        // Determine the current shifts
        foreach ($shifts as $shiftName => $shiftTimes) {
            $startTime = $shiftTimes['start'];
            $endTime = $shiftTimes['end'];
            
            if ($startTime > $endTime) { // Shift spans midnight
                if (($currentTime >= $startTime && $currentTime <= '23:59:59') || ($currentTime >= '00:00:00' && $currentTime <= $endTime)) {
                    $currentShifts[] = $shiftName;
                }
            } else { // Regular shift within the same day
                if ($currentTime >= $startTime && $currentTime <= $endTime) {
                    $currentShifts[] = $shiftName;
                }
            }
        }

        // get active employee
        $activeEmployees = EmployeeActive::with(['shift', 'employee', 'pos'])
            ->where('active_from', '<=', Carbon::now())
            ->where('expired_at', '>=', Carbon::now())
            ->where('line_id', $lineId->id)
            ->whereHas('shift', function ($query) use ($currentShifts) {
                $query->whereIn('name', $currentShifts);
            })
            ->whereHas('employee', function($query) use ($empOrigin){
                $query->where('origin_id', $empOrigin);
            })
            ->get();

        // get active pic
        $activePic = PicActive::with(['shift', 'employee'])
            ->where('active_from', '<=', Carbon::now())
            ->where('expired_at', '>=', Carbon::now())
            ->where('line_id', $lineId->id)
            ->whereHas('shift', function ($query) use ($currentShifts) {
                $query->where('name', $currentShifts);
            })
            ->whereHas('employee', function($query) use ($empOrigin){
                $query->where('origin_id', $empOrigin);
            })
            ->first();

        // get man henkaten
        $manHenkaten = Troubleshoot::with(['henkaten.shift', 'manAfter', 'manBefore', 'picAfter', 'picBefore'])
            ->whereHas('henkaten', function ($query) use ($lineId, $currentDate, $currentTime, $currentShifts) {
                $query
                    ->where('date', 'LIKE', $currentDate . '%')
                    ->where('line_id', $lineId->id)
                    ->whereHas('shift', function ($subQuery) use ($currentShifts) {
                        $subQuery->where('name', $currentShifts);
                    });
            })
            ->get();

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

    public function report()
    {
        return view('pages.website.report');
    }

    public function updateLineStatus(Line $lineId, Request $request)
    {
        $onOffSwitch = $request->onOffSwitch;

        $line = Line::findOrFail($lineId->id);

        try {
            DB::beginTransaction();

            $line->update([
                'status_man' => $onOffSwitch,
                'status_method' => $onOffSwitch,
                'status_machine' => $onOffSwitch,
                'status_material' => $onOffSwitch,
            ]);

            DB::commit();
            return ['status' => 'success'];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage
            ];
        } 
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
        $pivot = Pivot::where('active_date', $current_date)
                        ->where('origin_id', $empOrigin)
                        ->first();
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
                        ],500);
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
                        500
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
                        500
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
                        500
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
        // $this->mqttConnect('update' , '1');

        // Mengembalikan respons JSON tanpa if-else
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Tema berhasil ditambahkan!',
                'theme_id' => $parts[2],
                'theme_name' => $theme_name_final,
            ],
            200
        );
    }

    public function selectSupervisor($id)
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

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)
                        ->where('origin_id', $empOrigin)
                        ->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'karyawan tidak terdaftar!',
                ],
                404
            );
        }

        if (!$pivot) {
            try {
                DB::beginTransaction();

                // insert new data if pivot table is empty
                Pivot::create([
                    'origin_id' => $empOrigin,
                    'supervisor_id' => $pic,
                    'active_date' => $current_date,
                ]);

                DB::commit();

                // insert the value into session
                session(['selected_supervisor' => $pic]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $th,
                ],500);
            }
        } else {
            try {
                DB::beginTransaction();

                $pivot->update([
                    'supervisor_id' => $pic,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $th,
                ],500);
            }
        }

        // push to websocket
        $this->pushData(true);
        // $this->mqttConnect('update' , '1');

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Supervisor berhasil ditambahkan!',
                'name' => $employee->name,
                'photo' => $employee->photo,
                'role' => $employee->role,
                'npk' => $employee->npk,
            ],
            200
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
            ->where('origin_id', $empOrigin)
            ->first();

        if ($existingPics) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan ini sudah menjadi PIC 1 atau PIC 2.',
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)
                        ->where('origin_id', $empOrigin)
                        ->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'karyawan tidak terdaftar!',
                ],
                404
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
                    500
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
                    500
                );
            }
        }

        // push to websocket
        $this->pushData(true);
        // $this->mqttConnect('update' , '1');

        return response()->json(
            [
                'status' => 'success',
                'message' => 'PIC berhasil ditambahkan!',
                'name' => $employee->name,
                'photo' => $employee->photo,
                'role' => $employee->role,
                'npk' => $employee->npk,
            ],
            200
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
            ->where('origin_id', $empOrigin)
            ->first();

        if ($existingPics) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan ini sudah menjadi PIC 1 atau PIC 2.',
            ]);
        }

        // get current pivot
        $current_date = Carbon::now()->toDateString();
        $pivot = Pivot::where('active_date', $current_date)
                        ->where('origin_id', $empOrigin)
                        ->first();

        $employee = Employee::where('id', $pic)->first();
        if (!$employee) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'karyawan tidak terdaftar!',
                ],
                404
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
                    500
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
                    500
                );
            }
        }

        // push to websocket
        $this->pushData(true);
        // $this->mqttConnect('update' , '1');

        return response()->json(
            [
                'status' => 'success',
                'message' => 'PIC berhasil ditambahkan!',
                'name' => $employee->name,
                'photo' => $employee->photo,
                'role' => $employee->role,
                'npk' => $employee->npk,
            ],
            200
        );
    }
}
