<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class RefreshCsrfToken
{
    /**
     * Handle an incoming request and refresh CSRF token when needed
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
            
            // Add CSRF token to all responses for JavaScript access
            if ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\JsonResponse) {
                $response->header('X-CSRF-TOKEN', csrf_token());
            }
            
            return $response;
            
        } catch (TokenMismatchException $e) {
            // Handle CSRF token mismatch gracefully
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Session expired. Please refresh the page.',
                    'csrf_token' => csrf_token(),
                    'redirect' => route('login')
                ], 419);
            }
            
            // For web requests, redirect to custom 419 page
            return response()->view('errors.419', [], 419);
        }
    }
}
