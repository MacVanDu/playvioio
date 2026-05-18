<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        $rootUrl = rtrim((string) config('app.url'), '/');
        if ($rootUrl && !str_contains($rootUrl, 'localhost')) {
            URL::forceRootUrl(preg_replace('#/public$#', '', $rootUrl));
        }
    }

    
}
