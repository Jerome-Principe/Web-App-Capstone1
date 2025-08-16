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
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    // Define the belongsTo relationship
    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    // Boot method to handle any additional logic
    protected static function boot()
    {
        parent::boot();

        // When deleting a defect record, restore the quantity to the machine
        static::deleting(function ($machineDefect) {
            if ($machineDefect->machine) {
                $machineDefect->machine->quantity += $machineDefect->quantity;
                $machineDefect->machine->save();
            }
        });

        // When restoring a defect record, deduct the quantity from the machine
        static::restored(function ($machineDefect) {
            if ($machineDefect->machine) {
                $machineDefect->machine->quantity -= $machineDefect->quantity;
                $machineDefect->machine->save();
            }
        });
    }
}
