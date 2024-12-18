<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'type',
        'guideline',
        'day',
        'breakfast',
        'lunch',
        'dinner',
    ];
}