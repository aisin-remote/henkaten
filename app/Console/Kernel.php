<?php

namespace App\Console;

use App\Models\Line;
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
