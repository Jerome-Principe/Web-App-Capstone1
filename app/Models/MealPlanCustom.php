<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlanCustom extends Model
{
    use HasFactory;

    protected $table = 'meal_plans_custom';
    protected $fillable = [
        'category',
        'type',
        'guideline',
        'day',
        'breakfast',
        'lunch',
        'dinner',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}