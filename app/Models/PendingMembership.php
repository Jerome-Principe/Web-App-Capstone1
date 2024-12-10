<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingMembership extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
    ];

    /**
     * Relationship: RequestMembership.
     */
    public function requestMembership()
    {
        return $this->hasMany(RequestMembership::class, 'membership_id');
    }

    /**
     * Relationship: MedicalForm.
     */
    public function medicalForm()
    {
        return $this->hasMany(MedicalForm::class, 'membership_id');
    }

    /**
     * Relationship: MembershipPayment.
     */
    public function membershipPayments()
    {
        return $this->hasMany(MembershipPayment::class, 'membership_id');
    }

    /**
     * Get full name attribute.
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pendingMembership) {
            $pendingMembership->requestMembership()->delete();
            $pendingMembership->medicalForm()->delete();
            $pendingMembership->membershipPayments()->delete();
        });
    }
}
