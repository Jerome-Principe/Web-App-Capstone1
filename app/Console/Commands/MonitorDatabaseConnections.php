<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonitorDatabaseConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor database connections and log statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $pdo = DB::connection()->getPdo();

            // Get connection statistics
            $stats = $pdo->query("SHOW STATUS LIKE 'Connections'")->fetch();
            $maxConnections = $pdo->query("SHOW VARIABLES LIKE 'max_connections'")->fetch();
            $maxUserConnections = $pdo->query("SHOW VARIABLES LIKE 'max_user_connections'")->fetch();

            // Try to get max_connections_per_hour (may not be available on all hosts)
            try {
                $maxConnectionsPerHour = $pdo->query("SHOW VARIABLES LIKE 'max_connections_per_hour'")->fetch();
            } catch (\Exception $e) {
                $maxConnectionsPerHour = ['Value' => 'Not available'];
            }

            $this->info('Database Connection Statistics:');
            $this->line('Total Connections: ' . $stats['Value']);
            $this->line('Max Connections: ' . $maxConnections['Value']);
            $this->line('Max User Connections: ' . $maxUserConnections['Value']);
            $this->line('Max Connections Per Hour: ' . $maxConnectionsPerHour['Value']);

            // Calculate connection usage percentage
            $usagePercentage = ($stats['Value'] / $maxConnections['Value']) * 100;
            $this->line('Connection Usage: ' . number_format($usagePercentage, 2) . '%');

            // Log the statistics
            Log::info('Database connection statistics', [
                'total_connections' => $stats['Value'],
                'max_connections' => $maxConnections['Value'],
                'max_user_connections' => $maxUserConnections['Value'],
                'max_connections_per_hour' => $maxConnectionsPerHour['Value'],
                'usage_percentage' => $usagePercentage
            ]);

            // Warning if usage is high
            if ($usagePercentage > 80) {
                $this->warn('WARNING: Database connection usage is high (' . number_format($usagePercentage, 2) . '%)');
                Log::warning('High database connection usage detected: ' . number_format($usagePercentage, 2) . '%');
            }

        } catch (\Exception $e) {
            $this->error('Failed to monitor database connections: ' . $e->getMessage());
            Log::error('Database monitoring failed: ' . $e->getMessage());
        }
    }
}