<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DatabaseConnectionManager
{
    private static $connectionCount = 0;
    private static $maxConnections = 450; // Stay well below the 500 limit

    /**
     * Execute a database operation with connection management
     */
    public static function executeWithConnectionManagement(callable $callback, $connectionName = 'mysql')
    {
        $cacheKey = 'db_connection_count';
        $currentConnections = Cache::get($cacheKey, 0);

        // If we're approaching the limit, wait and retry
        if ($currentConnections >= self::$maxConnections) {
            Log::warning('Database connection limit approaching, implementing backoff');

            // Disconnect all connections to free up resources
            self::forceDisconnectAll();

            // Wait a moment for connections to be freed
            usleep(100000); // 100ms

            // Reset counter
            Cache::put($cacheKey, 0, 60);
        }

        try {
            // Increment connection counter
            Cache::increment($cacheKey, 1);
            self::$connectionCount++;

            // Execute the callback
            $result = $callback();

            // Immediately disconnect after operation
            DB::disconnect($connectionName);

            // Decrement connection counter
            Cache::decrement($cacheKey, 1);
            self::$connectionCount--;

            return $result;

        } catch (\PDOException $e) {
            // Force disconnect on error
            DB::disconnect($connectionName);
            Cache::decrement($cacheKey, 1);
            self::$connectionCount--;

            if (str_contains($e->getMessage(), 'max_connections_per_hour')) {
                Log::critical('Database connection limit exceeded', [
                    'connection_count' => self::$connectionCount,
                    'cached_count' => Cache::get($cacheKey, 0),
                    'error' => $e->getMessage()
                ]);

                // Implement exponential backoff
                self::implementBackoff();
                throw new \Exception('Service temporarily overloaded. Please try again in a moment.');
            }

            throw $e;
        }
    }

    /**
     * Force disconnect all database connections
     */
    public static function forceDisconnectAll()
    {
        try {
            DB::disconnect('mysql');
            DB::purge('mysql');

            // Clear connection counter
            Cache::forget('db_connection_count');
            self::$connectionCount = 0;

            Log::info('All database connections forcefully disconnected');
        } catch (\Exception $e) {
            Log::error('Error disconnecting database connections: ' . $e->getMessage());
        }
    }

    /**
     * Implement exponential backoff when connection limit is hit
     */
    private static function implementBackoff()
    {
        $backoffKey = 'db_backoff_until';
        $backoffUntil = Cache::get($backoffKey);

        if ($backoffUntil && now()->timestamp < $backoffUntil) {
            // Already in backoff mode
            return;
        }

        // Implement 30-second backoff
        $backoffTime = now()->addSeconds(30)->timestamp;
        Cache::put($backoffKey, $backoffTime, 60);

        Log::warning('Database connection backoff implemented for 30 seconds');
    }

    /**
     * Check if we're currently in backoff mode
     */
    public static function isInBackoffMode(): bool
    {
        $backoffKey = 'db_backoff_until';
        $backoffUntil = Cache::get($backoffKey);

        return $backoffUntil && now()->timestamp < $backoffUntil;
    }

    /**
     * Get current connection statistics
     */
    public static function getConnectionStats(): array
    {
        return [
            'current_connections' => self::$connectionCount,
            'cached_connections' => Cache::get('db_connection_count', 0),
            'max_connections' => self::$maxConnections,
            'in_backoff' => self::isInBackoffMode(),
            'backoff_until' => Cache::get('db_backoff_until')
        ];
    }
}
