<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use Illuminate\Http\Request;

class MembershipPaymentController extends Controller
{
    /**
     * Display the list of payments.
     */
    public function index()
    {
        // Get paginated list of payments
        $payments = MembershipPayment::paginate(10);

        // Return the view with the payments data
        return view('membership-payment-list', compact('payments'));
    }

    /**
     * Store a new payment submission.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'gcash_number' => 'required|string',
            'account_name' => 'required|string',
            'reference_number' => 'required|string|unique:membership_payments',
            // Expecting the URL of the proof of payment
            'proof_of_payment_url' => 'required|url',  // Expect a URL for the proof of payment
        ]);

        // Create a new membership payment record
        MembershipPayment::create([
            'gcash_number' => $request->gcash_number,
            'account_name' => $request->account_name,
            'reference_number' => $request->reference_number,
            // Store the URL of the uploaded proof of payment
            'proof_of_payment_url' => $request->proof_of_payment_url,  // Save the URL directly
        ]);

        // Return a success response
        return response()->json(['message' => 'Payment submitted successfully'], 201);
    }
}