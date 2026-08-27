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

            // Also create a record in membership_payments table for payment tracking
            MembershipPayment::create([
                'membership_id' => $request->membership_id,
                'payment_method' => $request->payment_method,
                'gcash_number' => $paymentData['gcash_number'] ?? null,
                'account_name' => $paymentData['account_name'] ?? null,
                'reference_number' => $paymentData['reference_number'] ?? null,
                'proof_of_payment_url' => $paymentData['proof_of_payment_url'] ?? null,
            ]);

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
        $query = MembershipRenewal::with('pendingMembership');

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('membership_type', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('payment_method', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('gcash_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('account_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('reference_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('status', 'LIKE', "%{$searchTerm}%");
            });
        }

        $renewals = $query->orderBy('created_at', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $renewals->appends(['search' => $request->search]);
        }

        // Return the view with the renewals data
        return view('membership-renewal', compact('renewals'));
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

            // Update membership in pending_memberships table (expiry date and membership type)
            $pendingMembership = $renewal->pendingMembership;
            if ($pendingMembership) {
                $pendingMembership->update([
                    'expiry_date' => $newExpiryDate,
                    'membership_type' => $renewal->membership_type, // Update membership type to the renewed type
                ]);
            }

            // Update the membership type in request_memberships table to reflect the renewed type
            $requestMembership = $pendingMembership?->requestMembership;
            if ($requestMembership) {
                $requestMembership->update([
                    'membership_type' => $renewal->membership_type,
                ]);
            }

            // Note: We no longer transfer renewal payment data to membership_payments table
            // to avoid duplicate data in the payment list

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
     * View proof of payment image.
     */
    public function viewProof($id)
    {
        try {
            $renewal = MembershipRenewal::findOrFail($id);

            if (!$renewal->proof_of_payment_url) {
                return response()->json(['error' => 'No proof of payment available'], 404);
            }

            // Get the file path from storage
            $filePath = storage_path('app/public/' . $renewal->proof_of_payment_url);

            if (!file_exists($filePath)) {
                return response()->json(['error' => 'Proof of payment file not found'], 404);
            }

            // Return the image file
            return response()->file($filePath);

        } catch (\Exception $e) {
            \Log::error('View proof failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to view proof of payment'], 500);
        }
    }

    /**
     * Transfer payment data to membership_payments table.
     * DEPRECATED: No longer used to avoid duplicate data in payment list
     */
    private function transferPaymentData(MembershipRenewal $renewal)
    {
        // This method is no longer used to prevent duplicate payment records
        // Renewal payment data stays in the membership_renewals table only
        return;

        // OLD CODE (commented out):
        // MembershipPayment::updateOrCreate(
        //     [
        //         'membership_id' => $renewal->membership_id,
        //         'reference_number' => $renewal->reference_number ?? 'CASH_' . time(),
        //     ],
        //     [
        //         'gcash_number' => $renewal->gcash_number,
        //         'account_name' => $renewal->account_name,
        //         'reference_number' => $renewal->reference_number ?? 'CASH_' . time(),
        //         'proof_of_payment_url' => $renewal->proof_of_payment_url,
        //     ]
        // );
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

        // Get filtered renewals by date
        $renewals = MembershipRenewal::with('pendingMembership')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Return the view with filtered renewals
        return view('membership-renewal', compact('renewals'));
    }

    /**
     * Fix membership types for existing approved renewals.
     */
    public function fixMembershipTypes()
    {
        try {
            // Get all approved renewals
            $approvedRenewals = MembershipRenewal::where('status', 'Approved')
                ->with(['pendingMembership', 'pendingMembership.requestMembership'])
                ->get();

            $updatedCount = 0;

            foreach ($approvedRenewals as $renewal) {
                $pendingMembership = $renewal->pendingMembership;
                $requestMembership = $pendingMembership?->requestMembership;

                if (!$pendingMembership || !$requestMembership) {
                    continue;
                }

                $renewalType = strtolower($renewal->membership_type);
                $currentPendingType = strtolower($pendingMembership->membership_type ?? '');
                $currentRequestType = strtolower($requestMembership->membership_type ?? '');

                $needsUpdate = false;

                // Check if pending_memberships table needs update
                if ($currentPendingType !== $renewalType) {
                    $pendingMembership->update(['membership_type' => $renewal->membership_type]);
                    $needsUpdate = true;
                }

                // Check if request_memberships table needs update
                if ($currentRequestType !== $renewalType) {
                    $requestMembership->update(['membership_type' => $renewal->membership_type]);
                    $needsUpdate = true;
                }

                if ($needsUpdate) {
                    $updatedCount++;
                }
            }

            return redirect()->back()->with('success', "Membership types fixed successfully! Updated {$updatedCount} memberships.");

        } catch (\Exception $e) {
            \Log::error('Fix membership types failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fix membership types: ' . $e->getMessage());
        }
    }
}