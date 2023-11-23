<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'employees';

    protected $guarded = ['id'];

    public function firstPicPivot()
    {
        return $this->hasMany(Pivot::class, 'first_pic_id');
    }
    
    public function secondPicPivot()
    {
        return $this->hasMany(Pivot::class, 'second_pic_id');
    }
    
    public function employeeActive()
    {
        return $this->hasMany(EmployeeActive::class);
    }

    public function picActive()
    {
        return $this->hasMany(PicActive::class);
    }

    public function manBefore()
    {
        return $this->hasMany(Troubleshoot::class, 'employee_before_id');
    }
    
    public function manAfter()
    {
        return $this->hasMany(Troubleshoot::class, 'employee_after_id');
    }
}
