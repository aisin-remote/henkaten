<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Henkaten extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'henkatens';
    
    protected $guarded = ['id'];

    public function troubleshoot()
    {
        return $this->hasOne(Troubleshoot::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function manBefore()
    {
        return $this->belongsTo(Employee::class, 'employee_before_id');
    }
    
    public function manAfter()
    {
        return $this->belongsTo(Employee::class, 'employee_after_id');
    }
}
