<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    // Method to send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otpCode = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        Otp::updateOrCreate(
            ['email' => $request->email],
            ['otp_code' => $otpCode, 'expires_at' => $expiresAt]
        );

        // 🔧 Try to send email and catch any errors
        try {
            Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otpCode));
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage()); // log to storage/logs/laravel.log

            return response()->json([
                'success' => false,
                'error' => 'Failed to send OTP. Reason: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully!'
        ]);
    }

    // Method to verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $otp = Otp::where('email', $request->email)
            ->where('otp_code', $request->otp)
            ->first();

        if (!$otp || $otp->isExpired()) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid or expired OTP'
            ], 422);
        }

        // OTP is valid, optionally delete it after verification
        $otp->delete();

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully!'
        ]);
    }
}
