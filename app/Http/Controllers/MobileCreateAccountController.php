<?php

namespace App\Http\Controllers;

use App\Models\PendingMembership;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobileCreateAccountController extends Controller
{
    // Handles account creation
    public function createAccount(Request $request)
    {
        // Validate the request input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:pending_memberships,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Return validation errors, if any
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if the email already exists
        $existingEmail = PendingMembership::where('email', $request->email)->first();
        if ($existingEmail) {
            return response()->json([
                'message' => 'The email address is already registered.',
            ], 409); // Conflict status code
        }

        try {
            // Create a pending membership
            $membership = PendingMembership::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => 'Pending',
            ]);

            return response()->json([
                'message' => 'Account created successfully. Awaiting approval.',
                'membership' => $membership,
            ], 201);
        } catch (\Exception $e) {
            // Handle unexpected errors gracefully
            return response()->json([
                'message' => 'An error occurred while creating the account. Please try again.',
                'error' => $e->getMessage(),
            ], 500); // Internal server error
        }
    }

    // Handles user login
    public function login(Request $request)
    {
        // Validate the request input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists with 'Approved' status
        $user = PendingMembership::where('email', $request->email)
            ->where('status', 'Approved')
            ->first();

        // Verify password
        if ($user && Hash::check($request->password, $user->password)) {
            // Generate a token for API authentication
            $token = $user->createToken('MobileApp')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials or unapproved membership.',
        ], 401);
    }

    // Handles user logout
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Delete the current token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // Validates if an email exists in the database
    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:pending_memberships,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        return response()->json([
            'message' => 'The email exists in the database!',
        ], 200);
    }
}
