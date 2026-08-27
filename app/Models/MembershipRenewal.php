<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MembershipRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'name',
        'membership_type',
        'payment_method',
        'gcash_number',
        'account_name',
        'reference_number',
        'proof_of_payment_url',
        'status',
        'amount',
        'renewal_date',
        'new_expiry_date',
    ];

    protected $casts = [
        'renewal_date' => 'date',
        'new_expiry_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Relationship: PendingMembership.
     */
    public function pendingMembership()
    {
        return $this->belongsTo(PendingMembership::class, 'membership_id');
    }

    /**
     * Calculate new expiry date based on membership type and current expiry date.
     */
    public function calculateNewExpiryDate()
    {
        $currentExpiryDate = $this->pendingMembership?->expiry_date;

        if (!$currentExpiryDate) {
            return null;
        }

        $baseDate = Carbon::parse($currentExpiryDate);

        return match (strtolower($this->membership_type)) {
            'bronze' => $baseDate->addMonth()->format('Y-m-d'),
            'silver' => $baseDate->addMonths(3)->format('Y-m-d'),
            'gold' => $baseDate->addMonths(6)->format('Y-m-d'),
            default => null,
        };
    }

    /**
     * Get the amount based on membership type.
     */
    public function getAmountAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return match (strtolower($this->membership_type)) {
            'gold' => 3500.00,
            'silver' => 2000.00,
            'bronze' => 800.00,
            default => 0.00,
        };
    }

    /**
     * Check if payment method is Cash.
     */
    public function isCashPayment()
    {
        return strtolower($this->payment_method) === 'cash';
    }

    /**
     * Check if payment method is GCash.
     */
    public function isGCashPayment()
    {
        return strtolower($this->payment_method) === 'gcash';
    }

    /**
     * Process payment method logic.
     */
    public function processPaymentMethod()
    {
        if ($this->isCashPayment()) {
            // Set GCash-related fields to null for Cash payments
            $this->gcash_number = null;
            $this->account_name = null;
            $this->reference_number = null;
            $this->proof_of_payment_url = null;
        }
        // For GCash payments, all fields should already be filled
    }
}
