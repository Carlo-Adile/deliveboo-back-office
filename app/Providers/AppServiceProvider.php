<?php

namespace App\Providers;

use Braintree\Gateway;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(Gateway::class, function ($app) {
            return new Gateway(
                [
                    'environment' => 'sandbox',
                    'merchantId' => '3qd8wwpsrrxth784',
                    'publicKey' => 'jczs2qwkvykmfjwd',
                    'privateKey' => '187a55d84ae0876003dc60b544cea123'
                ]
            );
        });
    }
}
