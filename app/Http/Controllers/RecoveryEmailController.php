<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\PendingMembership;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;       // For Signup
use App\Mail\RecoveryOtpMail;   // For Password Recovery

class RecoveryEmailController extends Controller
{
    /**
     * Check if email exists and send OTP for registration
     */

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $user = PendingMembership::where('email', $email)->first();

        return response()->json([
            'success' => true,
            'exists' => $user ? true : false,
        ]);
    }

    /**
     * Send OTP for account recovery (forgot password)
     */
    public function sendRecoveryOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $user = PendingMembership::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not found'], 404);
        }

        // Rate limit check: prevent frequent OTP requests
        if (Cache::has("recent_otp_request_{$email}")) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting another OTP.',
            ], 429);
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
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $email = $request->email;
        $otp = $request->otp;

        $cachedOtp = Cache::get("recovery_otp_{$email}");

        if (!$cachedOtp || $cachedOtp != $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP',
            ], 400);
        }

        // Optional: remove the OTP from cache after successful validation
        Cache::forget("recovery_otp_{$email}");

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully',
        ]);
    }

    public function setNewPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = PendingMembership::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not found.'], 404);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password updated.']);
    }

}
