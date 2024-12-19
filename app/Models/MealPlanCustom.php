<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlanCustom extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the default
    protected $table = 'meal_plans_custom';

    // Define fillable attributes
    protected $fillable = [
        'user_id',
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