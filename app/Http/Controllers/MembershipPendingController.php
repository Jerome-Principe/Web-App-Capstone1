<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingMembership;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Store a new membership request.
     */
    public function store(Request $request)
    {
        $membership = new PendingMembership();
        $membership->first_name = $request->first_name;
        $membership->last_name = $request->last_name;
        $membership->email = $request->email;
        $membership->password = bcrypt($request->password);
        $membership->membership_type = $request->membership_type;

        // Calculate and set the expiry date based on membership type
        $membership->expiry_date = PendingMembership::calculateExpiryDate($membership->membership_type);

        $membership->save();

        return redirect()->route('membership-pendings.index')->with('success', 'Membership created successfully.');
    }



    public function approve($id, Request $request)
    {
        $membership = PendingMembership::find($id);

        if (!$membership) {
            return redirect()->back()->withErrors(['Membership not found']);
        }

        $membership->membership_type = $request->input('membership_type', 'Standard');
        $membership->status = 'Approved';
        $membership->expiry_date = PendingMembership::calculateExpiryDate($membership->membership_type);
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
        $memberships = PendingMembership::whereIn('status', ['Approved', 'Declined'])->orderBy('id', 'desc')
            ->paginate(10);
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
            $membership->forceDelete();

            return redirect()->route('membership-pendings.trashed')->with('success', 'Membership permanently deleted, along with related data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the membership and related data.' . $e->getMessage());
        }
    }

    public function filterByDate(Request $request)
    {
        // Validate the date input
        $request->validate([
            'date' => 'required|date',
        ]);

        // Retrieve memberships filtered by the selected date and status 'Approved'
        $date = $request->input('date');
        $memberships = PendingMembership::where('status', 'Approved')
            ->whereDate('created_at', $date) // or any other date column if necessary
            ->paginate(10);

        return view('membership-list', compact('memberships', 'date'));
    }

    public function exportPdfByDate(Request $request)
    {
        $date = $request->get('date');
        // Filter memberships based on the selected date or fetch all if no date is provided
        $memberships = $date
            ? PendingMembership::whereDate('created_at', $date)->get()
            : PendingMembership::all();

        // Return PDF
        $pdf = Pdf::loadView('membership-list-pdf', compact('memberships', 'date'));
        return $pdf->download('membership-list.pdf');
    }

}
