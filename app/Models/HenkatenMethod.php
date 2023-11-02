<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HenkatenMethod extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'henkaten_method';

    protected $guarded = ['id'];
}
