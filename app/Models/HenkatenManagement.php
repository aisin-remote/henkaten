<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HenkatenManagement extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'henkaten_managements';

    protected $guarded = ['id'];
}
