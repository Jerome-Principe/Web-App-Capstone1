<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\RecoveryOtpMail;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->email;

        // Check if user exists
        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'We can\'t find a user with that email address.'
                ], 404);
            }
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Rate limit check: prevent frequent OTP requests
        if (Cache::has("recent_otp_request_{$email}")) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please wait before requesting another OTP.'
                ], 429);
            }
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Please wait before requesting another OTP.']);
        }

        // Mark email as recently requested
        Cache::put("recent_otp_request_{$email}", true, now()->addSeconds(60)); // 1-minute cooldown

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in cache for verification
        Cache::put("recovery_otp_{$email}", $otp, now()->addMinutes(5));

        // Send the email
        try {
            Mail::to($email)->send(new RecoveryOtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to send recovery OTP email: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.'
                ], 500);
            }
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        // If it's a JSON request (resend), return success response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully!'
            ]);
        }

        // Redirect to OTP verification page for regular form submissions
        return redirect()->route('password.otp')->with('email', $email);
    }
}
