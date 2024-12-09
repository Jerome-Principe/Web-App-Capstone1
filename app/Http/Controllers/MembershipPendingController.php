<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingMembership;

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

    public function approve($id)
    {
        $membership = PendingMembership::find($id);

        if (!$membership) {
            return redirect()->back()->withErrors(['Membership not found']);
        }

        $membership->status = 'Approved';
        $membership->save();

        return redirect()->route('membership.list')->with('success', 'Membership approved successfully');
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
        $memberships = PendingMembership::whereIn('status', ['Approved', 'Declined'])->paginate(10);
        return view('membership-list', compact('memberships'));
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
                ->with('success', 'Selected membership moved to trash.');
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

            // Delete related data explicitly
            $membership->medicalForm()->delete();
            $membership->membershipPayments()->delete();

            $membership->forceDelete();

            return redirect()->route('membership-pendings.trashed')->with('success', 'Membership permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the membership.');
        }
    }
}
