<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingMembership;

class MembershipPendingController extends Controller
{
    /**
     * Display a listing of the pending memberships.
     */
    public function index()
    {
        $pendingMemberships = PendingMembership::where('status', 'Pending')->paginate(10);
        return view('membership-pending-list', compact('pendingMemberships'));
    }

    /**
     * Approve a pending membership.
     */
    public function approve($id)
    {
        $membership = PendingMembership::findOrFail($id);
        $membership->update(['status' => 'Approved']);

        return redirect()->route('membership.list')
            ->with('success', 'Membership approved successfully.');
    }

    /**
     * Decline a pending membership.
     */
    public function decline($id)
    {
        $membership = PendingMembership::findOrFail($id);
        $membership->update(['status' => 'Declined']);

        return redirect()->route('membership.list')
            ->with('success', 'Membership declined successfully.');
    }

    /**
     * List all approved and declined memberships.
     */
    public function listApproved()
    {
        $memberships = PendingMembership::whereIn('status', ['Approved', 'Declined'])->paginate(10);
        return view('membership-list', compact('memberships'));
    }

    /**
     * Fetch pending memberships for API.
     */
    public function mGetMembershipPending()
    {
        return PendingMembership::where('status', 'Pending')->get();
    }

    /**
     * Bulk delete selected memberships.
     */
    public function destroyAll(Request $request)
    {
        $selectedIds = $request->input('selected', []);
        if (!empty($selectedIds)) {
            PendingMembership::whereIn('id', $selectedIds)->delete();
            return back()->with('success', 'Selected memberships moved to trash successfully.');
        }

        return back()->with('error', 'No memberships selected.');
    }
}
