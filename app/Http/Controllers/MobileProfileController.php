<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\PendingMembership;

class MobileProfileController extends Controller
{
    /**
     * Upload profile picture for mobile app
     */
    public function uploadProfileImage(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Handle file upload
            if ($request->hasFile('profileImage')) {
                $file = $request->file('profileImage');

                // Generate unique filename
                $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store file in public/uploads/profile_pictures directory
                $file->move(public_path('uploads/profile_pictures'), $fileName);

                // Update user's profile picture in database
                $user->profile_picture = 'uploads/profile_pictures/' . $fileName;
                $user->save();

                // Return the full URL for the uploaded image
                $imageUrl = url('uploads/profile_pictures/' . $fileName);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile image uploaded successfully',
                    'imageUrl' => $imageUrl,
                    'data' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'profileImageUrl' => $imageUrl
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image file provided'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user profile information for mobile app
     */
    public function getUserProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $profileImageUrl = $user->profile_picture ? url($user->profile_picture) : null;

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profileImageUrl' => $profileImageUrl
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete profile picture
     */
    public function deleteProfileImage(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Delete the file if it exists
            if ($user->profile_picture) {
                $filePath = public_path($user->profile_picture);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Clear the profile picture field in database
                $user->profile_picture = null;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile image deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete profile image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}