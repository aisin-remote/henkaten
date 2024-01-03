<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\EmployeeActive; // Make sure to use your actual model

class UpdateEmployeeShifts extends Command
{
    protected $signature = 'employee:update-shifts';
    protected $description = 'Update employee shifts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentShifts = EmployeeActive::select('employee_id', 'shift_id', 'line_id', 'pos_id')->get();

        $newShifts = $currentShifts->map(function ($employee) {
            $nextShiftUuid = $this->getNextShiftUuid($employee->shift_id);
            return [
                'employee_id' => $employee->employee_id,
                'shift_id' => $nextShiftUuid,
                'line_id' => $employee->line_id,
                'pos_id' => $employee->pos_id,
                'active_from' => Carbon::now()->startOfWeek(),
                'expired_at' => Carbon::now()->endOfWeek(),
            ];
        });

        // Example of creating each new shift record individually
        foreach ($newShifts as $newShift) {
            EmployeeActive::create($newShift);
        }

        $this->info('Employee shifts updated successfully.');
    }

    private function getNextShiftUuid($currentShiftUuid)
    {
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
}
