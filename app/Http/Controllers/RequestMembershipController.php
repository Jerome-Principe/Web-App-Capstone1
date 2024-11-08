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

        try {
            $membership = RequestMembership::create($request->all());
            return response()->json(['message' => 'Membership created successfully!', 'membership' => $membership], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving membership:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create membership.', 'error' => $e->getMessage()], 500);
        }

    }

}
