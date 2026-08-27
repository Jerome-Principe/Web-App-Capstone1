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
    public function index(Request $request)
    {
        $query = MembershipPayment::with('pendingMembership');

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('gcash_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('account_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('reference_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('pendingMembership', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('first_name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $payments->appends(['search' => $request->search]);
        }

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
            'membership_id' => 'required|exists:pending_memberships,id',
            'payment_method' => 'required|string|in:Cash,GCash',
        ]);

        $paymentData = [
            'membership_id' => $request->membership_id,
            'payment_method' => $request->payment_method,
        ];

        // Handle payment method specific validation and data
        if (strtolower($request->payment_method) === 'cash') {
            // For Cash payments, set GCash fields to null
            $paymentData['gcash_number'] = null;
            $paymentData['account_name'] = null;
            $paymentData['reference_number'] = null;
            $paymentData['proof_of_payment_url'] = null;
        } else {
            // For GCash payments, validate required fields
            $request->validate([
                'gcash_number' => 'required|string',
                'account_name' => 'required|string',
                'reference_number' => 'required|string|unique:membership_payments',
                'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $paymentData['gcash_number'] = $request->gcash_number;
            $paymentData['account_name'] = $request->account_name;
            $paymentData['reference_number'] = $request->reference_number;

            // Handle file upload for GCash payments
            if ($request->hasFile('proof_of_payment')) {
                $file = $request->file('proof_of_payment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('proof_of_payments', $filename);
                $paymentData['proof_of_payment_url'] = Storage::url('app/public/' . $filePath);
            }
        }

        // Save the new payment data
        $payment = MembershipPayment::create($paymentData);

        return response()->json([
            'message' => 'Payment submitted successfully',
            'payment_method' => $payment->payment_method,
            'proof_of_payment_url' => $payment->proof_of_payment_url,
        ], 201);
    }
}
