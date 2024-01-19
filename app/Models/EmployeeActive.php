<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeActive extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'employee_active';

    protected $guarded = ['id'];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function pos()
    {
        return $this->belongsTo(Position::class);
    }
    
    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
