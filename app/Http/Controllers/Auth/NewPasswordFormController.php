<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class NewPasswordFormController extends Controller
{
    /**
     * Display the password reset form.
     */
    public function create(): View|RedirectResponse
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-form', compact('email'));
    }

    /**
     * Handle the password reset.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $email = $request->email;
        $password = $request->request->get('password');

        // Find the user
        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'User not found']);
        }

        // Update the password
        $user->password = Hash::make($password);
        $user->save();

        // Clear session data
        session()->forget(['reset_email', 'email']);

        // Redirect to login with success message
        return redirect()->route('login')->with('status', 'Password has been reset successfully. You can now login with your new password.');
    }
}
