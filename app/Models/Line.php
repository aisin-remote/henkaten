<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Line extends Model
{
    use HasFactory;
    use HasUuids;
    
    protected $table = 'lines';

    protected $guarded = ['id'];

    public function henkaten()
    {
        return $this->hasMany(Henkaten::class, 'line_id');
    }

    public function employeeActive()
    {
        return $this->hasMany(EmployeeActive::class);
    }
}
