<?php

namespace App\Http\Controllers;
use App\Models\MembershipPayment;
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


}
