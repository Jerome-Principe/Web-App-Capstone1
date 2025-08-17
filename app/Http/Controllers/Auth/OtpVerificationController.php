<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /**
     * Display the OTP verification view.
     */
    public function create(): View|RedirectResponse
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Handle OTP verification.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $email = $request->email;
        $otp = $request->otp;

        $cachedOtp = Cache::get("recovery_otp_{$email}");

        if (!$cachedOtp || $cachedOtp != $otp) {
            return back()->withInput($request->only('email'))
                ->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        // OTP is valid, remove it from cache and redirect to password reset
        Cache::forget("recovery_otp_{$email}");

        // Store email in session for password reset
        session(['reset_email' => $email]);

        return redirect()->route('password.reset.form');
    }
}
