<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingMembership;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class RecoveryEmailController extends Controller
{
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

        // Send email
        try {
            Mail::to($email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('OTP Email failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP.'], 500);
        }

        return response()->json([
            'exists' => true,
            'message' => 'OTP sent to email.',
        ]);
    }
}
