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

        if (!$user) {
            return response()->json(['exists' => false], 200);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Cache the OTP for 10 minutes (if needed for verification later)
        Cache::put("signup_otp_{$email}", $otp, now()->addMinutes(10));

        // Send email using SendOtpMail
        try {
            Mail::to($email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('Signup OTP Email failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP.'], 500);
        }

        return response()->json([
            'exists' => true,
            'message' => 'OTP sent to email.',
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

        // Generate OTP
        $otp = rand(100000, 999999);

        // Cache the OTP for 5 minutes
        Cache::put("otp_{$email}", $otp, now()->addMinutes(5));

        // Send recovery OTP using RecoveryOtpMail
        try {
            Mail::to($email)->send(new RecoveryOtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to send recovery OTP email: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
        ]);
    }
}
