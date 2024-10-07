<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PicAttendance extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'pic_attendance';

    protected $guarded = ['id'];

    public function picActive()
    {
        return $this->belongsTo(PicActive::class);
    }
}
