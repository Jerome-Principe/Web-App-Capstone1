<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\AccountDeletionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $changes = [];

        // Track changes
        if ($data['name'] !== $user->name) {
            $changes[] = 'name';
        }
        if ($data['email'] !== $user->email) {
            $changes[] = 'email';
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $file = $request->file('profile_picture');
            $fileName = 'profile_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/profile_pictures', $fileName, 'public');

            $data['profile_picture'] = $path;
            $changes[] = 'profile_picture';
        }

        $user->update($data);

        // Log the changes
        if (!empty($changes)) {
            Log::info('Profile updated', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'changes' => $changes,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the user's profile picture.
     */
    public function removeProfilePicture(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->update(['profile_picture' => null]);

            // Log the action
            Log::info('Profile picture removed', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return Redirect::route('profile.edit')->with('success', 'Profile picture removed successfully!');
        }

        return Redirect::route('profile.edit')->with('info', 'No profile picture to remove.');
    }

    /**
     * Export user data.
     */
    public function exportData(Request $request): Response
    {
        $user = $request->user();

        $data = [
            'Personal Information' => [
                'Name' => $user->name,
                'Email' => $user->email,
                'Email Verified At' => $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'Not verified',
                'Created At' => $user->created_at->format('Y-m-d H:i:s'),
                'Last Updated' => $user->updated_at->format('Y-m-d H:i:s'),
            ],
            'Account Status' => [
                'Account Active' => 'Yes',
                'Profile Picture' => $user->profile_picture ? 'Yes' : 'No',
            ]
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Log the export
        Log::info('User data exported', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response($jsonData, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="user_data_' . $user->id . '_' . date('Y-m-d') . '.json"'
        ]);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Verify current password
        if (!Hash::check($data['current_password'], $user->password)) {
            return Redirect::back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);

        // Log the password change
        Log::info('Password updated', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return Redirect::route('profile.edit')->with('success', 'Password updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(AccountDeletionRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Log the account deletion
        Log::warning('Account deleted', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Delete profile picture if it exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Logout the user
        Auth::logout();

        // Delete the user
        $user->delete();

        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Your account has been permanently deleted.');
    }
}
