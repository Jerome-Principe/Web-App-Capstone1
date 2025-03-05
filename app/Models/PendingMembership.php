<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PendingMembership extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'membership_type',
        'status',
        'expiry_date', // Added expiry_date to fillable attributes
    ];

    /**
     * Automatically set expiry date when creating/updating a membership.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($membership) {
            $membership->expiry_date = self::calculateExpiryDate($membership->membership_type);
        });

        static::updating(function ($membership) {
            $membership->expiry_date = self::calculateExpiryDate($membership->membership_type);
        });

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
    public static function calculateExpiryDate($membershipType, $startDate = null)
    {
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::now(); // Use provided date or now()

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
