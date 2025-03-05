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
        'start_date', // Added start_date field
        'expiry_date', // Keep expiry_date
        'membership_type',
        'status',
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
