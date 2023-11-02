<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'skills';

    protected $guarded = ['id'];

    public function employeeSkill()
    {
        return $this->hasMany(EmployeeSkill::class, 'skill_id');
    }
    
    public function minimumSkill()
    {
        return $this->hasMany(MinimumSkill::class, 'skill_id');
    }
}
