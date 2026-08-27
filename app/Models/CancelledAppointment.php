<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelledAppointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'instructor_name',
        'selected_date',
        'selected_time',
        'payment_method',
        'proof_of_payment',
        'reason',
        'instructor_rate',
        'gym_rate',
        'total_amount',
    ];

    /**
     * Relationship with PendingMembership (mobile users).
     */
    public function user()
    {
        return $this->belongsTo(PendingMembership::class, 'user_id');
    }

    /**
     * Relationship to PendingMembership using user_id.
     */
    public function pendingMembership()
    {
        return $this->belongsTo(PendingMembership::class, 'user_id');
    }
}
