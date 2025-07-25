<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DatabaseConnectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow static pages to bypass database check
        $staticRoutes = ['/', '/readmorebtn', '/learnmorebtn', '/status'];
        if (in_array($request->path(), $staticRoutes)) {
            return $next($request);
        }

        $maxRetries = 3;
        $retryDelay = 1; // seconds

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                // Test database connection before processing request
                DB::connection()->getPdo();

                // If successful, proceed with the request
                return $next($request);

            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->getCode();
                $errorMessage = $e->getMessage();

                // Check if it's a connection limit error
                if (
                    strpos($errorMessage, 'max_connections_per_hour') !== false ||
                    strpos($errorMessage, 'User') !== false && strpos($errorMessage, 'exceeded') !== false
                ) {

                    Log::warning("Database connection limit exceeded (attempt {$attempt}/{$maxRetries}): " . $errorMessage);

                    // If this is the last attempt, return error page
                    if ($attempt === $maxRetries) {
                        return $this->handleConnectionLimitError($request);
                    }

                    // Wait before retrying
                    sleep($retryDelay);
                    $retryDelay *= 2; // Exponential backoff
                    continue;
                }

                // For other database errors, log and return error page
                Log::error('Database connection failed: ' . $errorMessage);
                return response()->view('errors.database', [], 503);

            } catch (\Exception $e) {
                Log::error('Unexpected database error: ' . $e->getMessage());
                return response()->view('errors.database', [], 503);
            }
        }

        // If we get here, all retries failed
        return $this->handleConnectionLimitError($request);
    }

    /**
     * Handle connection limit errors specifically
     */
    private function handleConnectionLimitError(Request $request)
    {
        // Check if we have a cached response for this route
        $cacheKey = 'db_error_response_' . md5($request->fullUrl());
        $cachedResponse = Cache::get($cacheKey);

        if ($cachedResponse) {
            return $cachedResponse;
        }

        // Create a response with retry headers
        $response = response()->view('errors.database', [
            'retryAfter' => 60, // Retry after 1 minute
            'isConnectionLimit' => true
        ], 503);

        // Add retry headers
        $response->header('Retry-After', 60);
        $response->header('X-Retry-After', 60);

        // Cache this response for 30 seconds to reduce database load
        Cache::put($cacheKey, $response, 30);

        return $response;
    }
}