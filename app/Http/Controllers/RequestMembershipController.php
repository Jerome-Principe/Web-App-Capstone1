<?php

namespace App\Http\Controllers;
use App\Models\RequestMembership;
use Illuminate\Http\Request;

class RequestMembershipController extends Controller
{
    //
    public function index()
    {
        //
        $memberships = RequestMembership::paginate(9);
        return view('membership-request-list', compact('memberships'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:request_memberships',
            'date' => 'required|date',
            'gender' => 'required|string',
            'age' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'mobile' => 'required|string',
            'membership_type' => 'required|string',
        ]);

        $membership = RequestMembership::create(
            $request->all()
        );
        if (!$membership) {
            return response()->json(['message' => 'Failed to create membership.'], 500);
        }

        return response()->json([
            'message' => 'Membership created successfully!',
            'membership' => $membership
        ]);
    }

}
