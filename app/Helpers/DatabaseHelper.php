<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DatabaseHelper
{
    /**
     * Get cached data or return fallback
     */
    public static function getCachedOrFallback($key, $fallback = null, $ttl = 300)
    {
        try {
            return Cache::get($key, $fallback);
        } catch (\Exception $e) {
            Log::warning('Cache access failed, using fallback for key: ' . $key);
            return $fallback;
        }
    }

    /**
     * Store data in cache with error handling
     */
    public static function cacheData($key, $data, $ttl = 300)
    {
        try {
            Cache::put($key, $data, $ttl);
            return true;
        } catch (\Exception $e) {
            Log::warning('Failed to cache data for key: ' . $key);
            return false;
        }
    }

    /**
     * Check if database is available
     */
    public static function isDatabaseAvailable()
    {
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get connection limit status
     */
    public static function getConnectionStatus()
    {
        $cacheKey = 'db_connection_status';

        // Check cache first
        $cached = self::getCachedOrFallback($cacheKey);
        if ($cached && $cached['timestamp'] > time() - 60) {
            return $cached;
        }

        // If database is not available, return cached status or default
        if (!self::isDatabaseAvailable()) {
            return $cached ?: [
                'available' => false,
                'error' => 'Database connection failed',
                'timestamp' => time()
            ];
        }

        try {
            $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();

            // Get connection statistics
            $stats = $pdo->query("SHOW STATUS LIKE 'Connections'")->fetch();
            $maxConnections = $pdo->query("SHOW VARIABLES LIKE 'max_connections'")->fetch();

            $status = [
                'available' => true,
                'total_connections' => $stats['Value'],
                'max_connections' => $maxConnections['Value'],
                'usage_percentage' => ($stats['Value'] / $maxConnections['Value']) * 100,
                'timestamp' => time()
            ];

            // Cache the status for 1 minute
            self::cacheData($cacheKey, $status, 60);

            return $status;
        } catch (\Exception $e) {
            $status = [
                'available' => false,
                'error' => $e->getMessage(),
                'timestamp' => time()
            ];

            self::cacheData($cacheKey, $status, 60);
            return $status;
        }
    }
}