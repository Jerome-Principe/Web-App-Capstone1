<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingMembership;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MembershipPendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendingMemberships = PendingMembership::where('status', 'Pending')->paginate(10);
        return view('membership-pending-list', compact('pendingMemberships'));
    }

    public function approve($id, Request $request)
    {
        $membership = PendingMembership::find($id);

        if (!$membership) {
            return redirect()->back()->withErrors(['error' => 'Membership not found']);
        }

        $requestMembership = $membership->requestMembership;

        if (!$requestMembership) {
            return redirect()->back()->withErrors(['error' => 'Request membership data not found']);
        }

        $startDate = Carbon::now()->format('Y-m-d');
        $expiryDate = $this->calculateExpiryDate($requestMembership->membership_type, $startDate);

        $membership->update([
            'status' => 'Approved',
            'start_date' => $startDate,
            'expiry_date' => $expiryDate,
        ]);

        return redirect()->route('membership.list')->with('success', 'Membership approved successfully');
    }

    /**
     * Calculate expiry date based on membership type.
     */
    private function calculateExpiryDate($membershipType, $startDate)
    {
        $date = Carbon::parse($startDate);

        return match (strtolower($membershipType)) {
            'bronze' => $date->addMonth()->format('Y-m-d'),
            'silver' => $date->addMonths(3)->format('Y-m-d'),
            'gold' => $date->addMonths(6)->format('Y-m-d'),
            default => null,
        };
    }

    public function decline($id)
    {
        $membership = PendingMembership::find($id);

        if (!$membership) {
            return redirect()->back()->withErrors(['Membership not found']);
        }

        $membership->status = 'Declined';
        $membership->save();

        return redirect()->route('membership.list')->with('success', 'Membership declined successfully');
    }

    public function listApproved()
    {
        $memberships = PendingMembership::whereIn('status', ['Approved', 'Declined'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Calculate total income using same logic as dashboard to ensure consistency
        // This prevents double counting of renewed memberships

        // Get renewed membership IDs
        $renewedMembershipIds = \App\Models\MembershipRenewal::where('status', 'Approved')
            ->pluck('membership_id')
            ->unique();

        // Revenue from NON-RENEWED memberships (use their original membership type)
        $nonRenewedRevenue = PendingMembership::where('status', 'Approved')
            ->whereNotIn('id', $renewedMembershipIds)
            ->get()
            ->sum(function ($membership) {
                $membershipType = optional($membership->requestMembership)->membership_type ?? '';

                return match (strtolower($membershipType)) {
                    'gold' => 3500,
                    'silver' => 2000,
                    'bronze' => 800,
                    default => 0,
                };
            });

        // For RENEWED memberships: calculate original payment + renewal payments
        $renewedMembershipsRevenue = 0;

        $renewedMemberships = PendingMembership::where('status', 'Approved')
            ->whereIn('id', $renewedMembershipIds)
            ->with('membershipRenewals')
            ->get();

        foreach ($renewedMemberships as $membership) {
            $approvedRenewals = $membership->membershipRenewals->where('status', 'Approved');

            if ($approvedRenewals->count() > 0) {
                // Sum all renewal amounts (this is what they actually paid for renewals)
                $renewalPayments = $approvedRenewals->sum('amount');

                // For the original membership, determine what they originally had
                // Simple logic: if they renewed to Silver, they were Bronze originally
                $firstRenewal = $approvedRenewals->sortBy('created_at')->first();
                $originalAmount = match (strtolower($firstRenewal->membership_type)) {
                    'silver' => 800,   // Renewed to Silver, was Bronze (₱800)
                    'gold' => 2000,    // Renewed to Gold, was Silver (₱2000)
                    'bronze' => 800,   // Shouldn't happen, but default to Bronze
                    default => 800,
                };

                $renewedMembershipsRevenue += $originalAmount + $renewalPayments;
            }
        }

        $totalIncome = $nonRenewedRevenue + $renewedMembershipsRevenue;

        return view('membership-list', compact('memberships', 'totalIncome'));
    }

    public function mGetMembershipPending()
    {
        return PendingMembership::where('status', 'Pending')->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAll(Request $request)
    {
        // Validate that selected IDs are provided
        if ($request->has('selected') && is_array($request->input('selected'))) {
            // Retrieve and delete the selected memberships
            PendingMembership::whereIn('id', $request->input('selected'))->delete();
            return back()->with('success', 'Selected memberships moved to trash successfully.');
        }

        return back()->with('error', 'No memberships selected.');
    }

    public function trashed()
    {
        $trashedMemberships = PendingMembership::onlyTrashed()->paginate(10);
        return view('trashed-membership-list', compact('trashedMemberships'));
    }

    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));
        if (!empty($selectedIds)) {
            PendingMembership::whereIn('id', $selectedIds)->delete();
            return redirect()->route('membership.list')
                ->with('success', 'Selected membership moved to archived.');
        }

        return redirect()->back()->with('error', 'No membership selected.');
    }

    public function restoreBulk(Request $request)
    {
        $membershipIds = explode(',', $request->input('selected'));

        if (empty($membershipIds)) {
            return back()->with('error', 'Please select at least one membership to restore.');
        }

        try {
            PendingMembership::onlyTrashed()->whereIn('id', $membershipIds)->restore();

            return redirect()->route('membership-pendings.trashed')->with('success', 'Selected membership restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected membership list.');
        }
    }

    public function restore($id)
    {
        try {
            $membership = PendingMembership::onlyTrashed()->findOrFail($id);
            $membership->restore();

            return redirect()->route('membership-pendings.trashed')->with('success', 'Membership restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the membership.');
        }
    }

    public function forceDelete($id)
    {
        try {
            $membership = PendingMembership::onlyTrashed()->findOrFail($id);
            $membership->forceDelete();

            return redirect()->route('membership-pendings.trashed')->with('success', 'Membership permanently deleted, along with related data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the membership and related data.' . $e->getMessage());
        }
    }

    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        $memberships = PendingMembership::where('status', 'Approved')
            ->whereDate('start_date', $date)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Calculate total income for filtered results using same logic as dashboard
        // Get renewed membership IDs
        $renewedMembershipIds = \App\Models\MembershipRenewal::where('status', 'Approved')
            ->pluck('membership_id')
            ->unique();

        // Revenue from NON-RENEWED memberships on this date
        $nonRenewedRevenue = $memberships->filter(function ($membership) use ($renewedMembershipIds) {
            return !$renewedMembershipIds->contains($membership->id);
        })->sum(function ($membership) {
            $membershipType = optional($membership->requestMembership)->membership_type ?? '';

            return match (strtolower($membershipType)) {
                'gold' => 3500,
                'silver' => 2000,
                'bronze' => 800,
                default => 0,
            };
        });

        // For RENEWED memberships on this date: calculate original payment + renewal payments
        $renewedMembershipsRevenue = 0;

        $renewedMembershipsOnDate = $memberships->filter(function ($membership) use ($renewedMembershipIds) {
            return $renewedMembershipIds->contains($membership->id);
        });

        foreach ($renewedMembershipsOnDate as $membership) {
            $approvedRenewals = $membership->membershipRenewals?->where('status', 'Approved') ?? collect();

            if ($approvedRenewals->count() > 0) {
                // Sum all renewal amounts (this is what they actually paid for renewals)
                $renewalPayments = $approvedRenewals->sum('amount');

                // For the original membership, determine what they originally had
                $firstRenewal = $approvedRenewals->sortBy('created_at')->first();
                $originalAmount = match (strtolower($firstRenewal->membership_type)) {
                    'silver' => 800,   // Renewed to Silver, was Bronze (₱800)
                    'gold' => 2000,    // Renewed to Gold, was Silver (₱2000)
                    'bronze' => 800,   // Shouldn't happen, but default to Bronze
                    default => 800,
                };

                $renewedMembershipsRevenue += $originalAmount + $renewalPayments;
            }
        }

        $totalIncome = $nonRenewedRevenue + $renewedMembershipsRevenue;

        return view('membership-list', compact('memberships', 'totalIncome'));
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->get('date');

        // Get only approved memberships based on date filter
        $memberships = $date
            ? PendingMembership::where('status', 'Approved')->whereDate('created_at', $date)->get()
            : PendingMembership::where('status', 'Approved')->get();

        // Calculate total income ONLY from approved memberships
        $totalIncome = $memberships->sum(function ($membership) {
            $membershipType = optional($membership->requestMembership)->membership_type ?? '';

            return match (strtolower($membershipType)) {
                'gold' => 3500,
                'silver' => 2000,
                'bronze' => 800,
                default => 0,
            };
        });

        // Add income from approved membership renewals
        $renewalIncome = $date
            ? \App\Models\MembershipRenewal::where('status', 'Approved')->whereDate('created_at', $date)->sum('amount')
            : \App\Models\MembershipRenewal::where('status', 'Approved')->sum('amount');

        $totalIncome += $renewalIncome;

        // Generate PDF
        $pdf = Pdf::loadView('membership-list-pdf', compact('memberships', 'date', 'totalIncome'));
        return $pdf->download('membership-list.pdf');
    }


}