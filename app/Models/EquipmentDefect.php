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
        'time',
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    // Define the belongsTo relationship
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
