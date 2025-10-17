<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PendingMembership extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_picture',
        'start_date',
        'expiry_date',
        'membership_type',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Automatically set expiry date when creating/updating a membership.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pendingMembership) {
            // Delete related records when the membership is soft-deleted
            $pendingMembership->requestMembership()->forceDelete();
            $pendingMembership->medicalForm()->forceDelete();
            $pendingMembership->membershipPayments()->forceDelete();
        });
    }

    /**
     * Calculate expiry date based on membership type.
     */
    public static function calculateExpiryDate($membershipType, $startDate)
    {
        $startDate = Carbon::parse($startDate); // Ensure it's a Carbon instance

        switch (strtolower($membershipType)) {
            case 'bronze':
                return $startDate->addMonth()->format('Y-m-d');
            case 'silver':
                return $startDate->addMonths(3)->format('Y-m-d');
            case 'gold':
                return $startDate->addMonths(6)->format('Y-m-d');
            default:
                return null;
        }
    }

    /**
     * Relationship: RequestMembership.
     */
    public function requestMembership()
    {
        return $this->hasOne(RequestMembership::class, 'membership_id');
    }

    /**
     * Relationship: MedicalForm.
     */
    public function medicalForm()
    {
        return $this->hasOne(MedicalForm::class, 'membership_id');
    }

    /**
     * Relationship: MembershipRenewal.
     */
    public function membershipRenewals()
    {
        return $this->hasMany(\App\Models\MembershipRenewal::class, 'membership_id');
    }

    /**
     * Check if this membership has approved renewals.
     */
    public function hasApprovedRenewals()
    {
        return $this->membershipRenewals()->where('status', 'Approved')->exists();
    }

    /**
     * Relationship: MembershipPayment.
     */
    public function membershipPayments()
    {
        return $this->hasMany(MembershipPayment::class, 'membership_id');
    }

    /**
     * Relationship: Meal Plans.
     */
    public function mealPlansCustom()
    {
        return $this->hasMany(MealPlanCustom::class, 'user_id');
    }

    /**
     * Get full name attribute.
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
