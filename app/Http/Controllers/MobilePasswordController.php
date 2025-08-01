<?php

namespace App\Http\Controllers;

use App\Models\PendingMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MobilePasswordController extends Controller
{
    /**
     * Change password for authenticated mobile users
     */
    public function changePassword(Request $request)
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        // Get authenticated user
        $user = $request->user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 401);
        }

        // Check if new password is different from current password
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'New password must be different from current password',
            ], 400);
        }

        // Check if new password is already used by other accounts
        $existingUserWithSamePassword = PendingMembership::where('id', '!=', $user->id)
            ->get()
            ->filter(function ($otherUser) use ($request) {
                return Hash::check($request->new_password, $otherUser->password);
            })
            ->first();

        if ($existingUserWithSamePassword) {
            return response()->json([
                'success' => false,
                'message' => 'This password is already used by another account. Please choose a different password.',
            ], 400);
        }

        try {
            // Update the password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password successfully updated',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'status' => $user->status,
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error changing password: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the password',
            ], 500);
        }
    }

    /**
     * Verify current password before allowing change
     */
    public function verifyCurrentPassword(Request $request)
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        // Get authenticated user
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Current password verified',
        ], 200);
    }

    /**
     * Get user security information
     */
    public function getSecurityInfo(Request $request)
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        // Get authenticated user
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'status' => $user->status,
                'last_updated' => $user->updated_at,
            ]
        ], 200);
    }
}