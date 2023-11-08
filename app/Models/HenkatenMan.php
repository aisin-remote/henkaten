<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HenkatenMan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'henkaten_man';

    protected $guarded = ['id'];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}