<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Line;
use App\Models\Shift;
use App\Models\Employee;
use App\Models\EmployeeActive;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // update at 14:10
        $schedule->call(function () {
            // Update the columns in the database using Eloquent
            $currentStatus = 'henkaten';
            $newStatus = 'running';
        
            $columnsToUpdate = [
                'status_man' => $newStatus,
                'status_method' => $newStatus,
                'status_material' => $newStatus,
                'status_machine' => $newStatus,
            ];
        
            Line::whereIn('status_man', [$currentStatus])
                ->orWhereIn('status_method', [$currentStatus])
                ->orWhereIn('status_material', [$currentStatus])
                ->orWhereIn('status_machine', [$currentStatus])
                ->update($columnsToUpdate);
        })->dailyAt('14:10:00');
        
        // update at 22:10
        $schedule->call(function () {
            // Update the columns in the database using Eloquent
            $currentStatus = 'henkaten';
            $newStatus = 'running';
        
            $columnsToUpdate = [
                'status_man' => $newStatus,
                'status_method' => $newStatus,
                'status_material' => $newStatus,
                'status_machine' => $newStatus,
            ];
        
            Line::whereIn('status_man', [$currentStatus])
                ->orWhereIn('status_method', [$currentStatus])
                ->orWhereIn('status_material', [$currentStatus])
                ->orWhereIn('status_machine', [$currentStatus])
                ->update($columnsToUpdate);
        })->dailyAt('22:10:00');
        
        // update at 06:00
        $schedule->call(function () {
            // Update the columns in the database using Eloquent
            $currentStatus = 'henkaten';
            $newStatus = 'running';
        
            $columnsToUpdate = [
                'status_man' => $newStatus,
                'status_method' => $newStatus,
                'status_material' => $newStatus,
                'status_machine' => $newStatus,
            ];
        
            Line::whereIn('status_man', [$currentStatus])
                ->orWhereIn('status_method', [$currentStatus])
                ->orWhereIn('status_material', [$currentStatus])
                ->orWhereIn('status_machine', [$currentStatus])
                ->update($columnsToUpdate);
        })->dailyAt('06:00:00');

        // auto update 
        $schedule->call(function () {
            $currentShifts = EmployeeActive::select('employee_id', 'shift_id','line_id','pos_id')->get();
    
            $newShifts = $currentShifts->map(function ($employee) {
                $nextShiftUuid = $this->getNextShiftUuid($employee->shift_id); // Implement this method to determine the next shift
            
                return [
                    'employee_id' => $employee->employee_id,
                    'shift_id' => $nextShiftUuid,
                    'line_id' => $employee->line_id,
                    'pos_id' => $employee->pos_id,
                    'active_from' => Carbon::now()->startOfWeek(),
                    'expired_at' => Carbon::now()->endOfWeek(),
                ];
            });

            EmployeeActive::insert($newShifts->toArray());
        })->weeklyOn(0, '23:59');
    }

    public function getNextShiftUuid($currentShiftUuid) {
    // Assuming Shift is your model name and it has 'name' and 'id' columns
        $shifts = \App\Models\Shift::whereIn('name', ['Shift 1', 'Shift 2', 'Shift 3'])
                                ->get()
                                ->keyBy('name');

        // Map the shift names to their IDs
        $shiftsMap = [
            $shifts['Shift 1']->id => $shifts['Shift 3']->id,
            $shifts['Shift 2']->id => $shifts['Shift 1']->id,
            $shifts['Shift 3']->id => $shifts['Shift 2']->id,
        ];

        return $shiftsMap[$currentShiftUuid] ?? null; // Return null or handle invalid UUID
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
