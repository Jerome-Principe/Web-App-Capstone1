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

        $membership->delete();

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
}
