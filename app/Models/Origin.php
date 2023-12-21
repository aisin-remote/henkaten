<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Origin extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'origins';

    protected $guarded = ['id'];

    public function line()
    {
        return $this->hasMany(Line::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
    
    public function pivot()
    {
        return $this->hasMany(Pivot::class);
    }
}
