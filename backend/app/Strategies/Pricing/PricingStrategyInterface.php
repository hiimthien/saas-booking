<?php

namespace App\Strategies\Pricing;

interface PricingStrategyInterface
{
    /**
     * Calculate the total price for a consultation.
     *
     * @param float $hourlyRate
     * @param int $durationMinutes
     * @return array
     */
    public function calculatePrice(float $hourlyRate, int $durationMinutes): array;
}
