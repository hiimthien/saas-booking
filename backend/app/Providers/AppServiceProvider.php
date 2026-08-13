<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Strategies\Pricing\PricingStrategyInterface::class,
            \App\Strategies\Pricing\StandardPricingStrategy::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\ConsultationRepositoryInterface::class,
            \App\Repositories\Eloquent\ConsultationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global API limit: 60 requests per minute
        \Illuminate\Support\Facades\RateLimiter::for('api', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Strict limit for Authentication endpoints (Login, Register): 5 times per minute
        \Illuminate\Support\Facades\RateLimiter::for('auth', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
        });

        // Strict limit for Bookings to prevent spam: 5 times per minute
        \Illuminate\Support\Facades\RateLimiter::for('booking', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });
    }
}
