<?php

namespace App\Http\Controllers;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class MembershipPaymentController extends Controller
{
    //
    public function index()
    {
        $payments = MembershipPayment::paginate(10);
        return view('membership-payment-list', compact('payments'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'gcash_number' => 'required|string',
            'account_name' => 'required|string',
            'reference_number' => 'required|string|unique:membership_payments',
            'proof_of_payment' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $proofOfPaymentPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');

        MembershipPayment::create([
            'gcash_number' => $request->gcash_number,
            'account_name' => $request->account_name,
            'reference_number' => $request->reference_number,
            'proof_of_payment_url' => Storage::url($proofOfPaymentPath),
        ]);

        return response()->json(['message' => 'Payment submitted successfully'], 201);
    }

    public function viewProof($id)
    {
        // Fetch the proof image URL from the MembershipPayment model based on the ID
        $proof = MembershipPayment::find($id); // Use MembershipPayment instead of Proof

        if (!$proof || !file_exists(public_path($proof->proof_of_payment_url))) {
            return abort(404); // Return a 404 if the proof or image doesn't exist
        }

        return response()->file(public_path($proof->proof_of_payment_url)); // Display the image
    }

}
