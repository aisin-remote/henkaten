<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Origin;
use App\Models\PicActive;
use Illuminate\Console\Command;
use App\Models\EmployeeActive; // Make sure to use your actual model

class UpdateEmployeeShiftsElc extends Command
{
    protected $signature = 'employee:update-shifts-elc';
    protected $description = 'Update employee shifts elc';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Set the current time to the start of the current week, then subtract a week
        $previousWeekStart = Carbon::now()
            ->startOfWeek()
            ->subWeek()
            ->format('Y-m-d');

        // Set the time to the end of that week
        $previousWeekEnd = Carbon::now()
            ->startOfWeek()
            ->subWeek()
            ->endOfWeek()
            ->format('Y-m-d');

            dd($previousWeekStart);
            
        $currentShifts = EmployeeActive::with('line')
                            ->where('active_from', '<=', $previousWeekEnd)
                            ->where('expired_at', '>=', $previousWeekStart)
                            ->whereHas('line', function ($query){
                                $query->where('origin_id', env('ORIGIN_ELC'));
                            })
                            ->get();
                            
        $currentPicShifts = PicActive::with('line')
                            ->where('active_from', '<=', $previousWeekEnd)
                            ->where('expired_at', '>=', $previousWeekStart)
                            ->whereHas('line', function ($query){
                                $query->where('origin_id', env('ORIGIN_ELC'));
                            })
                            ->get();

        $newShifts = $currentShifts->map(function ($employee) {
            $nextShiftUuid = $this->getNextShiftUuid($employee->shift_id);
            if ($nextShiftUuid === null) {
                // If the next shift UUID is null, remove the employee
                EmployeeActive::where('employee_id', $employee->employee_id)->delete();
                return null; // Do not include in the new shifts
            }
            return [
                'employee_id' => $employee->employee_id,
                'shift_id' => $nextShiftUuid,
                'line_id' => $employee->line_id,
                'pos_id' => $employee->pos_id,
                'active_from' => Carbon::now()->startOfWeek(),
                'expired_at' => Carbon::now()->endOfWeek(),
            ];
        })->filter(); // Remove null entries
        
        // PIC
        $newPicShifts = $currentPicShifts->map(function ($employee) {
            $nextPicShiftUuid = $this->getNextShiftUuid($employee->shift_id);
            if ($nextPicShiftUuid === null) {
                // If the next shift UUID is null, remove the employee
                PicActive::where('employee_id', $employee->employee_id)->delete();
                return null; // Do not include in the new shifts
            }
            return [
                'employee_id' => $employee->employee_id,
                'shift_id' => $nextPicShiftUuid,
                'line_id' => $employee->line_id,
                'pos_id' => $employee->pos_id,
                'active_from' => Carbon::now()->startOfWeek(),
                'expired_at' => Carbon::now()->endOfWeek(),
            ];
        })->filter(); // Remove null entries

        // Example of creating each new shift record individually
        // EMP
        foreach ($newShifts as $newShift) {
            EmployeeActive::create($newShift);
        }

        // PIC
        foreach ($newPicShifts as $newPicShift) {
            PicActive::create($newPicShift);
        }

        $this->info('Employee shifts elc updated successfully.');
    }

    public function getNextShiftUuid($currentShiftUuid)
    {
        $shifts = \App\Models\Shift::whereIn('name', ['Non Shift', 'Shift 3'])
                                ->get()
                                ->keyBy('name');

        // Map the shift names to their IDs
        $shiftsMap = [
            $shifts['Non Shift']->id => $shifts['Shift 3']->id,
            $shifts['Shift 3']->id => $shifts['Non Shift']->id,
        ];

        return $shiftsMap[$currentShiftUuid] ?? null;
    }
}
