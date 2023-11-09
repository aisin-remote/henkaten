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

    public function henkatenMachine()
    {
        return $this->hasMany(HenkatenMachine::class, 'line_id');
    }
    public function henkatenMan()
    {
        return $this->hasMany(HenkatenMan::class, 'line_id');
    }
    public function henkatenMethod()
    {
        return $this->hasMany(HenkatenMethod::class, 'line_id');
    }
    public function henkatenMaterial()
    {
        return $this->hasMany(HenkatenMaterial::class, 'line_id');
    }

    public function employeeActive()
    {
        return $this->hasMany(EmployeeActive::class);
    }
}
