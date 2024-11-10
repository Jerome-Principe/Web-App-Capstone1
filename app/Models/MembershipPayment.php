<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'gcash_number',
        'account_name',
        'reference_number',
        'proof_of_payment_url'
    ];
}
