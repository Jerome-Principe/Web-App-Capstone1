<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgramCustom extends Model
{
    use HasFactory;

    protected $table = 'workout_programs_custom';

    protected $fillable = [
        'user_id',
        'category',
        'type',
        'guideline',
        'day',
        'workout',
        'difficulty',
        'duration',
    ];

    public function user()
    {
        return $this->belongsTo(PendingMembership::class, 'user_id');
    }

}
