<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheService
{
    /**
     * Clear all dashboard-related cache when data changes
     * Call this after any CRUD operations that affect dashboard data
     */
    public static function clearDashboardCache()
    {
        $today = Carbon::now()->toDateString();

        // Clear all dashboard cache keys
        Cache::forget('dashboard_daily_' . $today);
        Cache::forget('dashboard_static');
        Cache::forget('dashboard_complex_' . $today);

        // Clear notification cache too
        Cache::forget('notification_count');
        Cache::forget('recent_notifications');
    }

    /**
     * Clear specific cache based on what type of data was modified
     */
    public static function clearSpecificCache($type)
    {
        $today = Carbon::now()->toDateString();

        switch ($type) {
            case 'membership':
            case 'walkin':
            case 'appointment':
            case 'attendance':
                Cache::forget('dashboard_daily_' . $today);
                Cache::forget('dashboard_complex_' . $today);
                break;

            case 'stock':
            case 'instructor':
                Cache::forget('dashboard_static');
                break;

            case 'notification':
                Cache::forget('notification_count');
                Cache::forget('recent_notifications');
                break;

            case 'all':
                self::clearDashboardCache();
                break;
        }
    }
}
