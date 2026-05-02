<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CryptoService;

class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Bind as singleton (one instance everywhere)
        $this->app->singleton(CryptoService::class, function ($app) {
            return new CryptoService();
        });

        // Optional alias
        $this->app->alias(CryptoService::class, 'crypto');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
