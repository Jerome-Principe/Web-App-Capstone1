<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cache:clear-app {--type=all : Type of cache to clear (all, dashboard, notification)}';

    /**
     * The console command description.
     */
    protected $description = 'Clear application-specific cache (dashboard, notifications)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');

        switch ($type) {
            case 'dashboard':
                CacheService::clearSpecificCache('all');
                $this->info('Dashboard cache cleared successfully!');
                break;

            case 'notification':
                CacheService::clearSpecificCache('notification');
                $this->info('Notification cache cleared successfully!');
                break;

            case 'all':
            default:
                CacheService::clearDashboardCache();
                $this->info('All application cache cleared successfully!');
                break;
        }

        return 0;
    }
}
