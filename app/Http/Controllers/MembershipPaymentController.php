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
            'proof_of_payment_url' => 'required|url',
        ]);

        $payment = new MembershipPayment();
        $payment->gcash_number = $request->gcash_number;
        $payment->account_name = $request->account_name;
        $payment->reference_number = $request->reference_number;
        $payment->proof_of_payment_url = $request->proof_of_payment_url;
        $payment->save();

        return response()->json(['message' => 'Payment submitted successfully'], 201);
    }


}
