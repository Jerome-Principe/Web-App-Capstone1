<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'machines';

    protected $fillable = ['item_name', 'quantity', 'date'];

    // Ensure timestamps are enabled
    public $timestamps = true;

    public function machineDefects()
    {
        return $this->hasMany(MachineDefect::class, 'machine_id');
    }

    // Boot method to handle cascading deletes
    protected static function boot()
    {
        parent::boot();

        // When deleting a machine, also delete related defect records
        static::deleting(function ($machine) {
            try {
                // Delete related defect records
                $machine->machineDefects()->delete();
            } catch (\Exception $e) {
                // Log the error but continue with the deletion
                \Log::error('Error deleting related defect records: ' . $e->getMessage());
            }
        });

        // When restoring a machine, also restore related defect records
        static::restored(function ($machine) {
            try {
                // Restore related defect records
                $machine->machineDefects()->restore();
            } catch (\Exception $e) {
                // Log the error but continue with the restoration
                \Log::error('Error restoring related defect records: ' . $e->getMessage());
            }
        });
    }
}
