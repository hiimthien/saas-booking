<?php

namespace App\Services;

use App\Models\ConsultantProfile;
use App\Repositories\Contracts\ConsultationRepositoryInterface;
use App\Strategies\Pricing\PricingStrategyInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmedMail;

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
        $pricing = $this->pricingStrategy->calculatePrice($consultant->hourly_rate, $durationMinutes);

        // 4. Save to Database using the Repository Pattern
        $ulid = (string) \Illuminate\Support\Str::ulid();
        $meetingLink = 'https://meet.jit.si/ConsultFlow-' . $ulid;

        $consultation = $this->consultationRepository->create([
            'ulid' => $ulid,
            'consultant_profile_id' => $consultant->id,
            'customer_id' => $customerId,
            'start_time' => $start,
            'end_time' => $end,
            'consultant_fee' => $pricing['consultant_fee'],
            'platform_fee' => $pricing['platform_fee'],
            'total_price' => $pricing['total_price'],
            'status' => 'pending',
            'notes' => $notes,
            'meeting_link' => $meetingLink,
        ]);

        // 5. Send Email Notifications
        try {
            // Re-fetch to load relationships if needed, or rely on model
            $consultation->load(['client', 'provider.user']);
            
            Mail::to($consultation->client->email)->queue(new BookingConfirmedMail($consultation, 'client'));
            Mail::to($consultation->provider->user->email)->queue(new BookingConfirmedMail($consultation, 'provider'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send booking emails: ' . $e->getMessage());
        }

        return $consultation;
    }
}
