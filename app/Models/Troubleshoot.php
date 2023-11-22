<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Troubleshoot extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'troubleshoots';

    protected $guarded = ['id'];

    public function henkaten()
    {
        return $this->belongsTo(Henkaten::class);    
    }
}