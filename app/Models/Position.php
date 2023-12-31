<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'positions';

    protected $guarded = ['id'];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function employeeActive()
    {
        return $this->hasMany(EmployeeActive::class);
    }
}
