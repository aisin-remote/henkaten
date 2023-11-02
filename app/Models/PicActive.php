<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PicActive extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'pic_active';

    protected $guarded = ['id'];
}
