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
        // Log the incoming request for debugging
        \Log::info('OTP Send Request received', [
            'email' => $request->email,
            'timestamp' => now()->toDateTimeString(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $request->validate(['email' => 'required|email']);

        $otpCode = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        try {
            // Store OTP in database
            $otp = Otp::updateOrCreate(
                ['email' => $request->email],
                ['otp_code' => $otpCode, 'expires_at' => $expiresAt]
            );

            \Log::info('OTP stored in database', [
                'email' => $request->email,
                'otp_id' => $otp->id,
                'expires_at' => $expiresAt->toDateTimeString()
            ]);

            // Try to send email with retry logic
            $emailSent = $this->sendEmailWithRetry($request->email, $otpCode);

            if ($emailSent) {
                \Log::info('OTP email sent successfully', [
                    'email' => $request->email,
                    'otp_code' => $otpCode // Remove this in production
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('OTP sending failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to send OTP. Please try again later.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Send email with retry logic and fallback
     */
    private function sendEmailWithRetry($email, $otpCode, $maxRetries = 3)
    {
        $retryCount = 0;
        $delay = 1; // seconds

        while ($retryCount < $maxRetries) {
            try {
                \Log::info("Attempting to send OTP email", [
                    'email' => $email,
                    'attempt' => $retryCount + 1,
                    'max_retries' => $maxRetries
                ]);

                Mail::to($email)->send(new \App\Mail\SendOtpMail($otpCode));

                \Log::info("OTP email sent successfully on attempt " . ($retryCount + 1));
                return true;

            } catch (\Exception $e) {
                $retryCount++;
                \Log::warning("OTP email send attempt failed", [
                    'email' => $email,
                    'attempt' => $retryCount,
                    'error' => $e->getMessage()
                ]);

                if ($retryCount < $maxRetries) {
                    // Wait before retrying (exponential backoff)
                    sleep($delay);
                    $delay *= 2; // Increase delay for next retry
                } else {
                    \Log::error("All OTP email send attempts failed", [
                        'email' => $email,
                        'total_attempts' => $maxRetries,
                        'final_error' => $e->getMessage()
                    ]);
                }
            }
        }

        return false;
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
