<?php

namespace App\Providers;

use App\Services\SiakadService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Opsional: jika ingin singleton
        $this->app->singleton(SiakadService::class, function ($app) {
            return new SiakadService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
