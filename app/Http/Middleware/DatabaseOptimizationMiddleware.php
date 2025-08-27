<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DatabaseOptimizationMiddleware
{
    /**
     * Handle an incoming request and optimize database connections.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Process the request first, then handle optimization
            $response = $next($request);

            // After processing, optimize connections
            $this->optimizeConnections();

            return $response;

        } catch (\PDOException $e) {
            // Handle database connection errors gracefully
            Log::error('Database connection error: ' . $e->getMessage(), [
                'request_url' => $request->fullUrl(),
                'user_id' => auth()->id() ?? 'guest'
            ]);

            return $this->handleConnectionError($e, $request);

        } catch (\Exception $e) {
            // Handle any other exceptions
            Log::error('Unexpected error in DatabaseOptimizationMiddleware: ' . $e->getMessage());

            // Let the request continue normally for non-database errors
            return $next($request);
        }
    }

    /**
     * Optimize database connections after processing
     */
    private function optimizeConnections(): void
    {
        try {
            // Disconnect from MySQL to free connections
            DB::disconnect('mysql');

            // Log connection optimization for monitoring
            Log::info('Database connections optimized', [
                'memory_usage' => memory_get_peak_usage(true),
                'timestamp' => now()
            ]);

        } catch (\Exception $e) {
            Log::warning('Failed to optimize database connections: ' . $e->getMessage());
        }
    }

    /**
     * Handle database connection errors with retry logic
     */
    private function handleConnectionError(\PDOException $e, Request $request): Response
    {
        $errorCode = $e->getCode();
        $errorMessage = $e->getMessage();

        // Check if it's a connection limit error
        if (
            str_contains($errorMessage, 'max_connections_per_hour') ||
            str_contains($errorMessage, 'Too many connections')
        ) {

            Log::critical('Database connection limit exceeded', [
                'error' => $errorMessage,
                'request' => $request->fullUrl(),
                'user_id' => auth()->id() ?? 'guest',
                'timestamp' => now()
            ]);

            // Return appropriate response based on request type
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Service temporarily unavailable due to high traffic.',
                    'message' => 'Please try again in a few moments.',
                    'retry_after' => 60
                ], 503);
            }

            return response()->view('errors.database-limit', [], 503);
        }

        // For other database errors, return generic error
        return response()->view('errors.503', [], 503);
    }
}
