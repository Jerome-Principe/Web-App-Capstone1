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

        // Send OTP email
        Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otpCode));

        return response()->json(['message' => 'OTP sent successfully!']);
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
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }

        // OTP is valid, optionally delete it after verification
        $otp->delete();

        return response()->json(['message' => 'OTP verified successfully!']);
    }
}
