<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'name',
        'starting_weight',
        'starting_date',
        'current_weight',
        'goal_weight',
        'weekly_goal',
        'activity',
    ];
}

