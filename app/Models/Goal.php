<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'name',
        'starting_weight',
        'current_weight',
        'goal_weight',
        'weekly_goal',
        'activity',
    ];
}

