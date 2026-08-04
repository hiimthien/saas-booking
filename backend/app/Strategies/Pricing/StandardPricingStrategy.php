<?php

namespace App\Strategies\Pricing;

class StandardPricingStrategy implements PricingStrategyInterface
{
    public function calculatePrice(float $hourlyRate, int $durationMinutes): float
    {
        // Convert minutes to hours and multiply by rate
        return round(($hourlyRate / 60) * $durationMinutes, 2);
    }
}
