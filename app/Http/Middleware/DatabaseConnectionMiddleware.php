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
        $staticRoutes = ['/', '/readmorebtn', '/learnmorebtn', '/status', '/login', '/register'];
        if (in_array($request->path(), $staticRoutes)) {
            return $next($request);
        }

        // Check if we're in a connection limit state
        if ($this->isConnectionLimitActive()) {
            return $this->handleConnectionLimitError($request);
        }

        $maxRetries = 2; // Reduced retries to prevent connection exhaustion
        $retryDelay = 0.5; // Reduced delay

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                // Test database connection with timeout
                $pdo = DB::connection()->getPdo();

                // Set connection timeout
                $pdo->setAttribute(\PDO::ATTR_TIMEOUT, 5);

                // Test with a simple query
                $pdo->query('SELECT 1');

                // If successful, proceed with the request
                return $next($request);

            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->getCode();
                $errorMessage = $e->getMessage();

                // Check if it's a connection limit error
                if (
                    strpos($errorMessage, 'max_connections_per_hour') !== false ||
                    strpos($errorMessage, 'User') !== false && strpos($errorMessage, 'exceeded') !== false ||
                    strpos($errorMessage, 'Too many connections') !== false
                ) {
                    Log::warning("Database connection limit exceeded (attempt {$attempt}/{$maxRetries}): " . $errorMessage);

                    // Set connection limit state
                    $this->setConnectionLimitState();

                    // If this is the last attempt, return error page
                    if ($attempt === $maxRetries) {
                        return $this->handleConnectionLimitError($request);
                    }

                    // Wait before retrying
                    usleep($retryDelay * 1000000); // Convert to microseconds
                    $retryDelay *= 1.5; // Gentle backoff
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
     * Check if connection limit is currently active
     */
    private function isConnectionLimitActive()
    {
        $cacheKey = 'db_connection_limit_active';
        $limitData = Cache::get($cacheKey);

        if (!$limitData) {
            return false;
        }

        // Check if the limit period has expired (5 minutes)
        if (time() - $limitData['timestamp'] > 300) {
            Cache::forget($cacheKey);
            return false;
        }

        return true;
    }

    /**
     * Set connection limit state
     */
    private function setConnectionLimitState()
    {
        $cacheKey = 'db_connection_limit_active';
        Cache::put($cacheKey, [
            'timestamp' => time(),
            'active' => true
        ], 300); // 5 minutes
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
            'retryAfter' => 30, // Reduced retry time to 30 seconds
            'isConnectionLimit' => true
        ], 503);

        // Add retry headers
        $response->header('Retry-After', 30);
        $response->header('X-Retry-After', 30);

        // Cache this response for 15 seconds to reduce database load
        Cache::put($cacheKey, $response, 15);

        return $response;
    }
}