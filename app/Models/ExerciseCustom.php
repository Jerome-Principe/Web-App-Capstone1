<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseCustom extends Model
{
    use HasFactory;

    protected $table = 'exercise_customs';

    protected $fillable = [
        'user_id',
        'category',
        'type',
        'guideline',
        'exercise',
        'description',
        'duration',
    ];

    public function user()
    {
        return $this->belongsTo(PendingMembership::class, 'user_id');
    }

}
