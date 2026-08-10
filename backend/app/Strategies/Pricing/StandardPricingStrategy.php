<?php

namespace App\Strategies\Pricing;

class StandardPricingStrategy implements PricingStrategyInterface
{
    public function calculatePrice(float $hourlyRate, int $durationMinutes): array
    {
        // Platform fee is fixed at $12.50 for now, could be dynamic later
        $platformFee = 12.50;
        
        // Convert minutes to hours and multiply by rate
        $consultantFee = round(($hourlyRate / 60) * $durationMinutes, 2);
        
        $totalPrice = $consultantFee + $platformFee;

        return [
            'consultant_fee' => $consultantFee,
            'platform_fee' => $platformFee,
            'total_price' => $totalPrice,
        ];
    }
}
