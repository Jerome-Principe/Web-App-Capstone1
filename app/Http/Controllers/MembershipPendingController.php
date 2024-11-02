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
        $pendingMemberships = PendingMembership::where('status', 'Pending')->get();
        return view('membership-pending-list', compact('pendingMemberships'));
    }


    public function approve($id)
    {
        $membership = PendingMembership::find($id);

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        $membership->status = 'Approved';
        $membership->save();

        return response()->json(['message' => 'Membership approved successfully']);
    }

    public function decline($id)
    {
        $membership = PendingMembership::find($id);

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        $membership->status = 'Declined';
        $membership->save();

        return response()->json(['message' => 'Membership declined successfully']);
    }

    public function mGetMembershipPending()
    {
        return PendingMembership::where('status', 'Pending')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
