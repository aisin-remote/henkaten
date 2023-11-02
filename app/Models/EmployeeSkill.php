<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSkill extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'employee_skills';

    protected $guarded = ['id'];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
