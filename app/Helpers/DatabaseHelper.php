<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
     * Check if database is available with timeout
     */
    public static function isDatabaseAvailable()
    {
        try {
            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_TIMEOUT, 3); // 3 second timeout
            $pdo->query('SELECT 1');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get connection limit status with improved error handling
     */
    public static function getConnectionStatus()
    {
        $cacheKey = 'db_connection_status';

        // Check cache first
        $cached = self::getCachedOrFallback($cacheKey);
        if ($cached && $cached['timestamp'] > time() - 30) { // Reduced cache time to 30 seconds
            return $cached;
        }

        // If database is not available, return cached status or default
        if (!self::isDatabaseAvailable()) {
            return $cached ?: [
                'available' => false,
                'error' => 'Database connection failed',
                'timestamp' => time(),
                'connection_limit' => false
            ];
        }

        try {
            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_TIMEOUT, 5);

            // Get connection statistics with error handling
            $stats = null;
            $maxConnections = null;

            try {
                $stats = $pdo->query("SHOW STATUS LIKE 'Connections'")->fetch();
                $maxConnections = $pdo->query("SHOW VARIABLES LIKE 'max_connections'")->fetch();
            } catch (\Exception $e) {
                Log::warning('Could not fetch connection statistics: ' . $e->getMessage());
            }

            $status = [
                'available' => true,
                'timestamp' => time(),
                'connection_limit' => false
            ];

            if ($stats && $maxConnections) {
                $status['total_connections'] = $stats['Value'];
                $status['max_connections'] = $maxConnections['Value'];
                $status['usage_percentage'] = ($stats['Value'] / $maxConnections['Value']) * 100;

                // Check if we're approaching connection limit
                if ($status['usage_percentage'] > 80) {
                    $status['connection_limit'] = true;
                    Log::warning('Database connection usage is high: ' . $status['usage_percentage'] . '%');
                }
            }

            // Cache the status for 30 seconds
            self::cacheData($cacheKey, $status, 30);

            return $status;
        } catch (\Exception $e) {
            $status = [
                'available' => false,
                'error' => $e->getMessage(),
                'timestamp' => time(),
                'connection_limit' => false
            ];

            self::cacheData($cacheKey, $status, 30);
            return $status;
        }
    }

    /**
     * Check if we're in a connection limit state
     */
    public static function isConnectionLimitActive()
    {
        $cacheKey = 'db_connection_limit_active';
        $limitData = Cache::get($cacheKey);

        if (!$limitData) {
            return false;
        }

        // Check if the limit period has expired (3 minutes)
        if (time() - $limitData['timestamp'] > 180) {
            Cache::forget($cacheKey);
            return false;
        }

        return true;
    }

    /**
     * Set connection limit state
     */
    public static function setConnectionLimitState()
    {
        $cacheKey = 'db_connection_limit_active';
        Cache::put($cacheKey, [
            'timestamp' => time(),
            'active' => true
        ], 180); // 3 minutes
    }

    /**
     * Clear connection limit state
     */
    public static function clearConnectionLimitState()
    {
        Cache::forget('db_connection_limit_active');
    }

    /**
     * Get database health status
     */
    public static function getDatabaseHealth()
    {
        $status = self::getConnectionStatus();

        if (!$status['available']) {
            return 'unhealthy';
        }

        if ($status['connection_limit'] || self::isConnectionLimitActive()) {
            return 'degraded';
        }

        return 'healthy';
    }
}