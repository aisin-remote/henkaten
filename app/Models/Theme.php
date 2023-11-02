<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'themes';

    protected $guarded = ['id'];

    public function pivot()
    {
        return $this->hasMany(Pivot::class);
    }
}
