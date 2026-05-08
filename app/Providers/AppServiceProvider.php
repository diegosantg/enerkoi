<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        Paginator::useBootstrapFive();
        if (str_contains(env('APP_URL'), 'ngrok')) {
            URL::forceRootUrl(env('APP_URL')); // 1. Bloquea el dominio exacto
            URL::forceScheme('https');         // 2. Bloquea el certificado seguro
        }
    
    }
}
