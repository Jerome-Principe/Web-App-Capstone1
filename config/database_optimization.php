<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connection Optimization Settings
    |--------------------------------------------------------------------------
    |
    | These settings help prevent database connection limit issues by
    | optimizing connection management and implementing smart retry logic.
    |
    */

    'connection_limits' => [
        'max_retries' => 2,
        'retry_delay' => 0.5, // seconds
        'connection_timeout' => 10, // seconds
        'query_timeout' => 5, // seconds
    ],

    'caching' => [
        'status_cache_ttl' => 30, // seconds
        'error_response_cache_ttl' => 15, // seconds
        'connection_limit_cache_ttl' => 180, // 3 minutes
    ],

    'monitoring' => [
        'alert_threshold' => 80, // percentage
        'critical_threshold' => 90, // percentage
        'auto_clear_threshold' => 50, // percentage
    ],

    'static_routes' => [
        '/',
        '/readmorebtn',
        '/learnmorebtn',
        '/status',
        '/login',
        '/register',
        '/forgot-password',
        '/reset-password',
    ],

    'error_handling' => [
        'retry_after' => 30, // seconds
        'max_error_responses' => 100, // per minute
    ],

];