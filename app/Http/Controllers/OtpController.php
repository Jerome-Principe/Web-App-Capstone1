<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    // Method to send OTP
    public function sendOtp(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $otpCode = rand(100000, 999999);
            $expiresAt = now()->addMinutes(10);

            // Create or update OTP for the email
            Otp::updateOrCreate(
                ['email' => $request->email],
                ['otp_code' => $otpCode, 'expires_at' => $expiresAt]
            );

            // Send OTP email
            Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otpCode));

            return response()->json(['message' => 'OTP sent successfully!']);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => 'Invalid email format'], 422);
        } catch (\Exception $e) {
            // Log any other errors
            Log::error('OTP Sending Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP'], 500);
        }
    }

    // Method to verify OTP
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|digits:6'
            ]);

            // Check if OTP exists and is valid
            $otp = Otp::where('email', $request->email)
                ->where('otp_code', $request->otp)
                ->first();

            if (!$otp || $otp->isExpired()) {
                return response()->json(['error' => 'Invalid or expired OTP'], 422);
            }

            // OTP is valid, delete it after verification
            $otp->delete();

            return response()->json(['message' => 'OTP verified successfully!']);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => 'Invalid OTP or email format'], 422);
        } catch (\Exception $e) {
            // Log any other errors
            Log::error('OTP Verification Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to verify OTP'], 500);
        }
    }
}
