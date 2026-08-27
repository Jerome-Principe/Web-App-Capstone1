<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\DeleteAccountRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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

        $user->fill($request->only('name', 'email'));

        if ($request->hasFile('profile_picture')) {
            try {
                $file = $request->file('profile_picture');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Ensure the directory exists
                $uploadPath = public_path('uploads/profile_pictures');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Move the file
                $file->move($uploadPath, $fileName);

                // Save the file path to the database
                $user->profile_picture = 'uploads/profile_pictures/' . $fileName;

                $message = 'Profile and picture updated successfully.';
            } catch (\Exception $e) {
                return Redirect::back()->withErrors(['profile_picture' => 'Failed to upload profile picture: ' . $e->getMessage()]);
            }
        } else {
            $message = 'Profile updated successfully.';
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', $message);
    }


    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return Redirect::back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Password updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(DeleteAccountRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            // Delete the user's profile picture if it exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            // Logout the user
            Auth::logout();

            // Delete the user account
            $user->delete();

            // Invalidate and regenerate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('success', 'Your account has been permanently deleted.');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['password' => 'An error occurred while deleting your account. Please try again.'], 'userDeletion');
        }
    }
}
