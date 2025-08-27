<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DatabaseConnectionManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DatabaseHealthCheck extends Command
{
    protected $signature = 'db:health-check {--reset : Reset connection counters}';
    protected $description = 'Check database connection health and manage connection limits';

    public function handle()
    {
        if ($this->option('reset')) {
            $this->resetConnections();
            return;
        }

        $this->info('=== Database Connection Health Check ===');

        // Get connection statistics
        $stats = DatabaseConnectionManager::getConnectionStats();

        $this->table(
            ['Metric', 'Value'],
            [
                ['Current Connections', $stats['current_connections']],
                ['Cached Connections', $stats['cached_connections']],
                ['Max Connections', $stats['max_connections']],
                ['In Backoff Mode', $stats['in_backoff'] ? 'YES' : 'NO'],
                ['Backoff Until', $stats['backoff_until'] ? date('Y-m-d H:i:s', $stats['backoff_until']) : 'N/A'],
            ]
        );

        // Test database connection
        try {
            $start = microtime(true);
            DB::select('SELECT 1');
            $duration = round((microtime(true) - $start) * 1000, 2);

            $this->info("✅ Database connection test: {$duration}ms");
        } catch (\Exception $e) {
            $this->error("❌ Database connection failed: " . $e->getMessage());
        }

        // Check if we're approaching limits
        $connectionPercentage = ($stats['cached_connections'] / $stats['max_connections']) * 100;

        if ($connectionPercentage > 80) {
            $this->warn("⚠️  Warning: Connection usage at {$connectionPercentage}%");
            $this->info("Consider implementing connection pooling or reducing concurrent requests.");
        } else {
            $this->info("✅ Connection usage healthy at {$connectionPercentage}%");
        }

        // Recommendations
        $this->info("\n=== Recommendations ===");
        if ($stats['in_backoff']) {
            $this->warn("• System is in backoff mode - connections will be limited");
        }

        if ($stats['cached_connections'] > 300) {
            $this->warn("• High connection count detected - consider optimizing queries");
        }

        $this->info("• Run 'php artisan db:health-check --reset' to reset connection counters");
    }

    private function resetConnections()
    {
        $this->info('Resetting database connection counters...');

        // Force disconnect all connections
        DatabaseConnectionManager::forceDisconnectAll();

        // Clear all connection-related cache
        Cache::forget('db_connection_count');
        Cache::forget('db_backoff_until');

        $this->info('✅ Database connections reset successfully');

        // Show new stats
        $stats = DatabaseConnectionManager::getConnectionStats();
        $this->info("Current connections: {$stats['current_connections']}");
        $this->info("Cached connections: {$stats['cached_connections']}");
    }
}
