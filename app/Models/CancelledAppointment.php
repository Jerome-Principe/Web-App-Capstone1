<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instructor_name',
        'selected_date',
        'selected_time',
        'payment_method',
        'proof_of_payment',
        'reason',
    ];

    /**
     * Relationship with User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
