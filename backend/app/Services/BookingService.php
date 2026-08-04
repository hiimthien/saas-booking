<?php

namespace App\Services;

use App\Models\ConsultantProfile;
use App\Repositories\Contracts\ConsultationRepositoryInterface;
use App\Strategies\Pricing\PricingStrategyInterface;
use Carbon\Carbon;
use Exception;

class BookingService
{
    protected $consultationRepository;
    protected $pricingStrategy;

    public function __construct(
        ConsultationRepositoryInterface $consultationRepository,
        PricingStrategyInterface $pricingStrategy
    ) {
        $this->consultationRepository = $consultationRepository;
        $this->pricingStrategy = $pricingStrategy;
    }

    /**
     * Handle the booking process.
     *
     * @param int $customerId
     * @param ConsultantProfile $consultant
     * @param string $startTime
     * @param int $durationMinutes
     * @param string|null $notes
     * @return \App\Models\Consultation
     * @throws Exception
     */
    public function createBooking(int $customerId, ConsultantProfile $consultant, string $startTime, int $durationMinutes, ?string $notes = null)
    {
        // 1. Calculate start and end times
        $start = Carbon::parse($startTime);
        $end = (clone $start)->addMinutes($durationMinutes);

        // 2. Validate availability (Simplified for this example)
        // In a real app, you would check if $start and $end overlap with existing bookings
        // or if they fall outside of WorkingHours.

        // 3. Calculate price using the Strategy Pattern
        $totalPrice = $this->pricingStrategy->calculatePrice($consultant->hourly_rate, $durationMinutes);

        // 4. Save to Database using the Repository Pattern
        $consultation = $this->consultationRepository->create([
            'consultant_profile_id' => $consultant->id,
            'customer_id' => $customerId,
            'start_time' => $start,
            'end_time' => $end,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $notes,
        ]);

        return $consultation;
    }
}
