<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share Vite availability with all views
        View::composer('*', function ($view) {
            $viteManifestExists = File::exists(public_path('build/manifest.json'));
            $view->with('viteManifestExists', $viteManifestExists);
        });
    }
}
