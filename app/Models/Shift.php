<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'shifts';

    protected $guarded = ['id'];

    public function employeeActive()
    {
        return $this->hasMany(EmployeeActive::class);
    }
    
    public function picActive()
    {
        return $this->hasMany(PicActive::class);
    }
    
    public function henkaten()
    {
        return $this->hasMany(Henkaten::class);
    }
}
