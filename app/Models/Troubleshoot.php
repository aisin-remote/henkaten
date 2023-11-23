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

    public function manBefore()
    {
        return $this->belongsTo(Employee::class, 'employee_before_id');
    }
    
    public function manAfter()
    {
        return $this->belongsTo(Employee::class, 'employee_after_id');
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'done_by');
    }
}
