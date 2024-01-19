<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'attendance';

    protected $guarded = ['id'];

    public function employeeActive()
    {
        return $this->belongsTo(EmployeeActive::class);
    }
}
