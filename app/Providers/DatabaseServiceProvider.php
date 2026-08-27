<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Monitor database queries in development
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $time = $query->time;

                // Log slow queries
                if ($time > 1000) { // Log queries taking more than 1 second
                    Log::warning('Slow database query detected', [
                        'sql' => $sql,
                        'bindings' => $bindings,
                        'time' => $time
                    ]);
                }
            });
        }

        // Handle database connection errors globally
        DB::whenQueryingForLongerThan(5000, function ($connection) {
            Log::warning('Database query taking longer than 5 seconds', [
                'connection' => $connection->getName()
            ]);
        });
    }
}