<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'type',
        'guideline',
        'day',
        'workout',
        'difficulty',
        'duration',
    ];

}
