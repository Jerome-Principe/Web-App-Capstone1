<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate file as an image
        ]);

        // Handle file upload
        if ($request->hasFile('proof_of_payment')) {
            $file = $request->file('proof_of_payment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/proof_of_payments', $filename); // Store file in storage/app/public/proof_of_payments

            // Save the new payment data
            $payment = MembershipPayment::create([
                'gcash_number' => $request->gcash_number,
                'account_name' => $request->account_name,
                'reference_number' => $request->reference_number,
                'proof_of_payment_url' => Storage::url($filePath), // Save URL for accessing the file
            ]);

            return response()->json(['message' => 'Payment submitted successfully'], 201);
        } else {
            return response()->json(['error' => 'Proof of payment is required'], 422);
        }
    }

}