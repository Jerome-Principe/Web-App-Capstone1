<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'equipments';
    protected $fillable = ['item_name', 'quantity', 'date'];

    // Ensure timestamps are enabled
    public $timestamps = true;

    // Define the hasMany relationship with EquipmentDefect
    public function equipmentDefects()
    {
        return $this->hasMany(EquipmentDefect::class, 'equipment_id');
    }

    // Boot method to handle cascading deletes
    protected static function boot()
    {
        parent::boot();

        // When deleting an equipment, also delete related defect records
        static::deleting(function ($equipment) {
            try {
                // Delete related defect records
                $equipment->equipmentDefects()->delete();
            } catch (\Exception $e) {
                // Log the error but continue with the deletion
                \Log::error('Error deleting related defect records: ' . $e->getMessage());
            }
        });

        // When restoring an equipment, also restore related defect records
        static::restored(function ($equipment) {
            try {
                // Restore related defect records
                $equipment->equipmentDefects()->restore();
            } catch (\Exception $e) {
                // Log the error but continue with the restoration
                \Log::error('Error restoring related defect records: ' . $e->getMessage());
            }
        });
    }
}
