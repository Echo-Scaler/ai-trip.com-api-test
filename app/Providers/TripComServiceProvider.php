<?php

namespace App\Providers;

use App\Contracts\TripComApiContract;
use App\Services\TripCom\MockTripComApiService;
use App\Services\TripCom\TripComApiService;
use Illuminate\Support\ServiceProvider;

class TripComServiceProvider extends ServiceProvider
{
    /**
     * Register the Trip.com API service.
     */
    public function register(): void
    {
        $this->app->singleton(TripComApiContract::class, function ($app) {
            if (config('tripcom.use_mock', true)) {
                return new MockTripComApiService();
            }

            return new TripComApiService();
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
