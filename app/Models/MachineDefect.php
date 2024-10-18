<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineDefect extends Model
{
    use HasFactory;
    protected $table = 'machine_defects';
    protected $fillable = [
        'machine_id',
        'quantity',
        'defect',
        'date',
        'time'
    ];


    // Define the belongsTo relationship
    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }
}
