<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'user_id',
        'selected_date',
        'selected_time',
        'status',
    ];

    // Relationships (assuming you have Instructor and User models)
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
