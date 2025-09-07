<?php

namespace App\Http\Controllers;
use App\Models\RequestMembership;
use Illuminate\Http\Request;
use App\Models\PendingMembership; // Added this import

class RequestMembershipController extends Controller
{
    //
    public function index()
    {
        //
        $memberships = RequestMembership::with('pendingMembership')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Adjust the number per page as needed
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

    public function show($id)
    {
        $membership = RequestMembership::find($id); // Find by ID or use any logic to retrieve a specific membership
        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }
        return response()->json($membership);
    }

    public function getUserMembership(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Find the user's membership request
        $membership = RequestMembership::where('email', $user->email)->first();

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        return response()->json($membership);
    }

    /**
     * Get user's membership details including start_date, expiry_date, and membership_type
     */
    public function getUserMembershipDetails(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Find the user's membership details from PendingMembership
        $membership = PendingMembership::where('email', $user->email)
            ->where('status', 'Approved')
            ->first();

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        // Get the related RequestMembership for membership_type
        $requestMembership = $membership->requestMembership;

        $membershipDetails = [
            'first_name' => $membership->first_name,
            'last_name' => $membership->last_name,
            'email' => $membership->email,
            'start_date' => $membership->start_date,
            'expiry_date' => $membership->expiry_date,
            'membership_type' => $requestMembership?->membership_type ?? $membership->membership_type,
            'status' => $membership->status,
        ];

        return response()->json($membershipDetails);
    }

    /**
     * Update user profile information via mobile API
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Find the user's membership request
        $membership = RequestMembership::where('email', $user->email)->first();

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'age' => 'nullable|integer|min:1|max:120',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:10',
            'address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:20',
            'email' => 'required|email|unique:request_memberships,email,' . $membership->id,
            'work' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
        ]);

        try {
            // Update the RequestMembership table
            $membership->update($request->only([
                'first_name',
                'last_name',
                'middle_name',
                'date',
                'gender',
                'age',
                'weight',
                'height',
                'address',
                'postal_code',
                'email',
                'work',
                'mobile'
            ]));

            // Also update the PendingMembership table to keep the membership list in sync
            $pendingMembership = PendingMembership::where('email', $user->email)->first();
            if ($pendingMembership) {
                $pendingMembership->update([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                ]);
            }

            return response()->json([
                'message' => 'Profile updated successfully!',
                'membership' => $membership->fresh()
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error updating profile:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to update profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
