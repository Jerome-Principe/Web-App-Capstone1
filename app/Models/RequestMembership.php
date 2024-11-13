<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'date',
        'gender',
        'age',
        'weight',
        'height',
        'address',
        'postal_code',
        'email',
        'work',
        'mobile',
        'gym_source',
        'membership_type',
    ];

    // Relationship to PendingMembership
    public function pendingMembership()
    {
        return $this->belongsTo(PendingMembership::class, 'membership_id');
    }
}