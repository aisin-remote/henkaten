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
