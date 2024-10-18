<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDefect extends Model
{
    use HasFactory;

    protected $table = 'equipment_defects';

    protected $fillable = [
        'equipment_id',
        'quantity',
        'defect',
        'date',
        'time',
    ];

    // Define the belongsTo relationship
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
