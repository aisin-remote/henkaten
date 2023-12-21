<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pivot extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'pivots';

    protected $guarded = ['id'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    
    public function firstPic()
    {
        return $this->belongsTo(Employee::class, 'first_pic_id');
    }
    
    public function secondPic()
    {
        return $this->belongsTo(Employee::class, 'second_pic_id');
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }
}