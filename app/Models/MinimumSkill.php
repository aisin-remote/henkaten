<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MinimumSkill extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'minimum_skills';

    protected $guarded = ['id'];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
