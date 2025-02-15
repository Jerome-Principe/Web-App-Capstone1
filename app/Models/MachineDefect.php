<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineDefect extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'machine_defects';
    protected $fillable = [
        'machine_id',
        'quantity',
        'defect',
        'date',
        'time'
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    // Define the belongsTo relationship
    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }
}
