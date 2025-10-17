<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');
        $remember = $this->boolean('remember');

        // Debug logging
        \Log::info('Login attempt', [
            'email' => $credentials['email'],
            'remember' => $remember,
            'ip' => $this->ip()
        ]);

        // Try to authenticate with User model first (for admin/cashier/instructor)
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            \Log::info('User authentication successful', ['email' => $credentials['email']]);
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // If User authentication fails, try PendingMembership model (for gym members)
        // First check if user exists in pending_memberships table
        $pendingUser = \App\Models\PendingMembership::where('email', $credentials['email'])->first();
        if ($pendingUser && Hash::check($credentials['password'], $pendingUser->password)) {
            \Log::info('PendingMembership authentication successful', ['email' => $credentials['email']]);
            // Manually log in the user
            Auth::guard('pending_memberships')->login($pendingUser, $remember);
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // If both fail, hit rate limiter and throw validation exception
        \Log::warning('Authentication failed for both guards', ['email' => $credentials['email']]);
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
