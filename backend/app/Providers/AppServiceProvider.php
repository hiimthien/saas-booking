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
        //
    }
}
