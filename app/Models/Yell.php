<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Yell extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'yells';

    protected $guarded = ['id'];

    public function pivot()
    {
        return $this->hasMany(Pivot::class);
    }
}
