<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentDefect extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipment_defects';

    protected $fillable = [
        'equipment_id',
        'quantity',
        'defect',
        'date',
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    // Define the belongsTo relationship
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    // Boot method to handle any additional logic
    protected static function boot()
    {
        parent::boot();

        // When deleting a defect record, restore the quantity to the equipment
        static::deleting(function ($equipmentDefect) {
            if ($equipmentDefect->equipment) {
                $equipmentDefect->equipment->quantity += $equipmentDefect->quantity;
                $equipmentDefect->equipment->save();
            }
        });

        // When restoring a defect record, deduct the quantity from the equipment
        static::restored(function ($equipmentDefect) {
            if ($equipmentDefect->equipment) {
                $equipmentDefect->equipment->quantity -= $equipmentDefect->quantity;
                $equipmentDefect->equipment->save();
            }
        });
    }
}
