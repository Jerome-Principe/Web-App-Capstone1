<?php

namespace App\Http\Controllers;
use App\Models\RequestMembership;
use Illuminate\Http\Request;

class RequestMembershipController extends Controller
{
    //
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'User ID is required'], 400);
        }

        $membership = RequestMembership::where('membership_id', $userId)->first();

        if (!$membership) {
            return response()->json(['message' => 'No matching membership found'], 404);
        }

        return response()->json($membership);
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

    public function show($id)
    {
        $membership = RequestMembership::find($id); // Find by ID or use any logic to retrieve a specific membership
        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }
        return response()->json($membership);
    }

}
