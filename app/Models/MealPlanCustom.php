<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlanCustom extends Model
{
    use HasFactory;

    protected $table = 'meal_plans_custom';
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

    public function pendingMembership()
    {
        return $this->belongsTo(PendingMembership::class, 'user_id');
    }

    public function getUserNameAttribute()
    {
        return $this->pendingMembership ? $this->pendingMembership->name : 'N/A';
    }
}