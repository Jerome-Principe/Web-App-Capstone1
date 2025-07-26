<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Helpers\DatabaseHelper;

class MonitorDatabaseConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:monitor {--alert-threshold=80 : Connection usage threshold for alerts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor database connections and alert on high usage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = $this->option('alert-threshold');

        $this->info('🔍 Monitoring database connections...');

        try {
            $status = DatabaseHelper::getConnectionStatus();

            if (!$status['available']) {
                $this->error('❌ Database is not available');
                $this->error('Error: ' . ($status['error'] ?? 'Unknown error'));
                return 1;
            }

            $usage = $status['usage_percentage'] ?? 0;
            $totalConnections = $status['total_connections'] ?? 0;
            $maxConnections = $status['max_connections'] ?? 0;

            $this->info("📊 Connection Status:");
            $this->line("   • Total Connections: {$totalConnections}");
            $this->line("   • Max Connections: {$maxConnections}");
            $this->line("   • Usage: " . number_format($usage, 1) . "%");

            // Check if we're approaching the limit
            if ($usage >= $threshold) {
                $this->warn("⚠️  WARNING: Database connection usage is at " . number_format($usage, 1) . "%");
                $this->warn("   This is above the alert threshold of {$threshold}%");

                // Log the warning
                Log::warning("Database connection usage is high: " . number_format($usage, 1) . "%");

                // Set connection limit state if usage is very high
                if ($usage >= 90) {
                    DatabaseHelper::setConnectionLimitState();
                    $this->error("🚨 CRITICAL: Setting connection limit state");
                }

                return 1;
            }

            // Check if connection limit state should be cleared
            if (DatabaseHelper::isConnectionLimitActive()) {
                $this->info("🔄 Connection limit state is active");

                // Clear if usage is back to normal
                if ($usage < 50) {
                    DatabaseHelper::clearConnectionLimitState();
                    $this->info("✅ Connection limit state cleared - usage is back to normal");
                }
            }

            $this->info("✅ Database connections are healthy");
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error monitoring database: ' . $e->getMessage());
            Log::error('Database monitoring failed: ' . $e->getMessage());
            return 1;
        }
    }
}