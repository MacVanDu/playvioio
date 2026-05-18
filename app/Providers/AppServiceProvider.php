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
        $rootUrl = rtrim((string) config('app.url', 'https://marios.games'), '/');
        if (str_contains($rootUrl, 'localhost')) {
            $rootUrl = 'https://marios.games';
        }
        $rootUrl = preg_replace('#/public$#', '', $rootUrl);

        URL::forceRootUrl($rootUrl ?: 'https://marios.games');

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }

    
}
