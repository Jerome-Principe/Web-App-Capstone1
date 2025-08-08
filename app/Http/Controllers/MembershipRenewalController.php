<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\MembershipRenewal;
use App\Models\PendingMembership;
use App\Models\RequestMembership;
use App\Models\MembershipPayment;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipRenewalController extends Controller
{
    /**
     * Store a new membership renewal application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:pending_memberships,id',
            'name' => 'required|string|max:255',
            'membership_type' => 'required|string|in:Gold,Silver,Bronze',
            'payment_method' => 'required|string|in:Cash,GCash',
            'gcash_number' => 'nullable|string|max:20',
            'account_name' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'proof_of_payment' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            // Check if membership exists and is active
            $membership = PendingMembership::findOrFail($request->membership_id);

            if ($membership->status !== 'Approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Membership must be approved to request renewal.'
                ], 400);
            }

            // Process payment method logic
            $paymentData = [
                'membership_id' => $request->membership_id,
                'name' => $request->name,
                'membership_type' => $request->membership_type,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'renewal_date' => now()->format('Y-m-d'),
                'status' => 'Pending',
            ];

            // Handle payment method specific fields
            if (strtolower($request->payment_method) === 'cash') {
                // For Cash payments, set GCash fields to null
                $paymentData['gcash_number'] = null;
                $paymentData['account_name'] = null;
                $paymentData['reference_number'] = null;
                $paymentData['proof_of_payment_url'] = null;
            } else {
                // For GCash payments, validate required fields
                if (!$request->gcash_number || !$request->account_name) {
                    return response()->json([
                        'success' => false,
                        'message' => 'GCash number and account name are required for GCash payments.'
                    ], 400);
                }

                $paymentData['gcash_number'] = $request->gcash_number;
                $paymentData['account_name'] = $request->account_name;
                $paymentData['reference_number'] = $request->reference_number ?? 'GCASH_' . time();

                // Handle proof of payment upload
                if ($request->hasFile('proof_of_payment')) {
                    $proofPath = $request->file('proof_of_payment')->store('proofs', 'public');
                    $paymentData['proof_of_payment_url'] = $proofPath;
                }
            }

            $renewal = MembershipRenewal::create($paymentData);

            return response()->json([
                'success' => true,
                'message' => 'Membership renewal request submitted successfully!',
                'data' => $renewal
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Membership renewal submission failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit membership renewal request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of membership renewal applications.
     */
    public function index(Request $request)
    {
        try {
            $renewals = MembershipRenewal::with('pendingMembership')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // If date filter is applied
            if ($request->has('date') && $request->date) {
                $renewals = MembershipRenewal::with('pendingMembership')
                    ->whereDate('created_at', $request->date)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }

            return view('membership-renewal', compact('renewals'));
        } catch (\Exception $e) {
            \Log::error('Error loading membership renewals: ' . $e->getMessage());
            $renewals = collect([]); // Empty collection as fallback
            return view('membership-renewal', compact('renewals'));
        }
    }

    /**
     * Approve a membership renewal application.
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $renewal = MembershipRenewal::with('pendingMembership')->findOrFail($id);

            if ($renewal->status !== 'Pending') {
                return redirect()->back()->with('error', 'This renewal has already been processed.');
            }

            // Process payment method logic
            $renewal->processPaymentMethod();

            // Calculate new expiry date
            $newExpiryDate = $renewal->calculateNewExpiryDate();

            if (!$newExpiryDate) {
                return redirect()->back()->with('error', 'Unable to calculate new expiry date.');
            }

            // Update renewal status
            $renewal->update([
                'status' => 'Approved',
                'new_expiry_date' => $newExpiryDate,
            ]);

            // Update membership in pending_memberships table
            $pendingMembership = $renewal->pendingMembership;
            if ($pendingMembership) {
                $pendingMembership->update([
                    'membership_type' => $renewal->membership_type,
                    'expiry_date' => $newExpiryDate,
                ]);
            }

            // Update membership in request_memberships table
            $requestMembership = RequestMembership::where('membership_id', $renewal->membership_id)->first();
            if ($requestMembership) {
                $requestMembership->update([
                    'membership_type' => $renewal->membership_type,
                ]);
            }

            // Transfer payment data to membership_payments table
            $this->transferPaymentData($renewal);

            DB::commit();

            return redirect()->back()->with('success', 'Membership renewal approved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Membership renewal approval failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve membership renewal: ' . $e->getMessage());
        }
    }

    /**
     * Decline a membership renewal application.
     */
    public function decline($id)
    {
        try {
            $renewal = MembershipRenewal::findOrFail($id);

            if ($renewal->status !== 'Pending') {
                return redirect()->back()->with('error', 'This renewal has already been processed.');
            }

            $renewal->update(['status' => 'Declined']);

            return redirect()->back()->with('success', 'Membership renewal declined successfully!');
        } catch (\Exception $e) {
            \Log::error('Membership renewal decline failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to decline membership renewal: ' . $e->getMessage());
        }
    }

    /**
     * Transfer payment data to membership_payments table.
     */
    private function transferPaymentData(MembershipRenewal $renewal)
    {
        // Create or update payment record
        MembershipPayment::updateOrCreate(
            [
                'membership_id' => $renewal->membership_id,
                'reference_number' => $renewal->reference_number ?? 'CASH_' . time(),
            ],
            [
                'gcash_number' => $renewal->gcash_number,
                'account_name' => $renewal->account_name,
                'reference_number' => $renewal->reference_number ?? 'CASH_' . time(),
                'proof_of_payment_url' => $renewal->proof_of_payment_url,
            ]
        );
    }

    /**
     * Export membership renewal data to PDF.
     */
    public function exportPdf(Request $request)
    {
        try {
            $renewals = MembershipRenewal::with('pendingMembership')
                ->when($request->date, function ($query, $date) {
                    return $query->whereDate('created_at', $date);
                })
                ->get();

            // Generate PDF using DomPDF
            $pdf = Pdf::loadView('pdf.membership-renewal', compact('renewals'));
            return $pdf->download('membership-renewal-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            \Log::error('PDF export failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to export PDF: ' . $e->getMessage());
        }
    }

    /**
     * Filter membership renewal applications by date.
     */
    public function filterByDate(Request $request)
    {
        $date = $request->get('date');

        if (!$date) {
            return redirect()->route('membership-renewal.index');
        }

        return redirect()->route('membership-renewal.index', ['date' => $date]);
    }
}