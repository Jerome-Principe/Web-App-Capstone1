<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingAppointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'instructor_id',
        'user_id',
        'selected_date',
        'selected_time',
        'payment_method',
        'gcash_account_name',
        'gcash_account_number',
        'proof_of_payment',
        'status',
    ];

    // Relationships (assuming you have Instructor and User models)
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function pendingMembership()
    {
        return $this->belongsTo(PendingMembership::class, 'user_id');
    }
}