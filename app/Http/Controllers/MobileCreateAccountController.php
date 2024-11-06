<?php

namespace App\Http\Controllers;

use App\Models\PendingMembership;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class MobileCreateAccountController extends Controller
{
    public function createAccount(Request $request)
    {
        return PendingMembership::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  // Encrypt the password
            'status' => 'Pending'  // Default status as Pending
        ]);
    }

    // MobileCreateAccountController.php
    public function login(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if user exists and has 'Approved' status
        $user = PendingMembership::where('email', $request->email)
            ->where('status', 'Approved')
            ->first();

        // Verify password
        if ($user && \Hash::check($request->password, $user->password)) {
            // Here you could return a token for API authentication
            // Assuming you use Laravel Sanctum or JWT:
            $token = $user->createToken('MobileApp')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials or unapproved membership'], 401);
        }
    }

}
