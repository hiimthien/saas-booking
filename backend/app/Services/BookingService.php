<?php

namespace App\Services;

use App\Models\ConsultantProfile;
use App\Models\Consultation;
use App\Models\WorkingHour;
use App\Repositories\Contracts\ConsultationRepositoryInterface;
use App\Strategies\Pricing\PricingStrategyInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\BookingConfirmedMail;
use App\Services\WalletService;

class BookingService
{
    protected $consultationRepository;
    protected $pricingStrategy;
    protected $walletService;

    public function __construct(
        ConsultationRepositoryInterface $consultationRepository,
        PricingStrategyInterface $pricingStrategy,
        WalletService $walletService
    ) {
        $this->consultationRepository = $consultationRepository;
        $this->pricingStrategy = $pricingStrategy;
        $this->walletService = $walletService;
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
        return DB::transaction(function () use ($customerId, $consultant, $startTime, $durationMinutes, $notes) {
            // 1. Calculate start and end times
            $start = Carbon::parse($startTime);
            $end = (clone $start)->addMinutes($durationMinutes);

            // 2. Lock the consultant's WorkingHour for the selected time
            $workingHour = WorkingHour::where('consultant_profile_id', $consultant->id)
                ->where('day_of_week', $start->dayOfWeek)
                ->where('start_time', '<=', $start->format('H:i:s'))
                ->where('end_time', '>=', $end->format('H:i:s'))
                ->where('is_closed', false)
                ->lockForUpdate()
                ->first();

            if (!$workingHour) {
                throw new Exception('Chuyên gia không có lịch làm việc trong khung giờ này hoặc đã đóng cửa.');
            }

            // 3. Check for overlapping bookings and lock the Consultation records
            $existingBooking = Consultation::where('consultant_profile_id', $consultant->id)
                ->where(function ($query) use ($start, $end) {
                    $query->where('start_time', '<', $end)
                          ->where('end_time', '>', $start);
                })
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate()
                ->exists();

            if ($existingBooking) {
                throw new Exception('Rất tiếc, khung giờ này vừa mới được người khác đặt trước.');
            }

            // 4. Calculate price using the Strategy Pattern
            $pricing = $this->pricingStrategy->calculatePrice($consultant->hourly_rate, $durationMinutes);

            // 5. Save to Database using the Repository Pattern
            $ulid = (string) Str::ulid();
            // Sinh URL phòng họp Jitsi độc nhất dựa trên ULID
            $meetingUrl = 'https://meet.jit.si/saas-booking-' . $ulid;

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
                'meeting_url' => $meetingUrl, // Sử dụng trường meeting_url mới
            ]);

            // 6. Giao tác vụ gửi Email cho Background Job (Redis Queue)
            \App\Jobs\SendBookingConfirmationEmail::dispatchAfterResponse($consultation);

            // 7. Auto-Cancel Job: Hủy lịch tự động nếu không thanh toán sau 15 phút
            \App\Jobs\CancelUnpaidBookingJob::dispatch($consultation)->delay(now()->addMinutes(15));

            return $consultation;
        });
    }

    /**
     * Cancel a booking and handle refund policy.
     *
     * @param int $bookingId
     * @param int $userId
     * @return \App\Models\Consultation
     * @throws Exception
     */
    public function cancelBooking(int $bookingId, int $userId)
    {
        return DB::transaction(function () use ($bookingId, $userId) {
            // 1. Lock the consultation record to prevent race conditions during cancellation
            $consultation = Consultation::where('id', $bookingId)->lockForUpdate()->first();

            if (!$consultation) {
                throw new Exception("Lịch hẹn không tồn tại.");
            }

            // 2. Authorization: Only the creator (client) can cancel
            if ($consultation->customer_id !== $userId) {
                throw new Exception("Bạn không có quyền hủy lịch hẹn này.");
            }

            // 3. Status check: Only pending or confirmed can be cancelled
            if (!in_array($consultation->status, ['pending', 'confirmed'])) {
                throw new Exception("Chỉ có thể hủy lịch hẹn đang chờ duyệt hoặc đã xác nhận.");
            }

            // 4. Refund Policy Check
            $startTime = Carbon::parse($consultation->start_time);
            $hoursUntilStart = now()->diffInHours($startTime, false);

            if ($hoursUntilStart >= 24) {
                // Refund 100% to Wallet
                $this->walletService->deposit(
                    userId: $userId,
                    amount: $consultation->total_price,
                    type: 'refund',
                    description: 'Hoàn tiền hủy lịch hẹn #' . $consultation->ulid,
                    reference: $consultation
                );
            } else {
                // Dưới 24h: Không hoàn tiền (Hoặc sau này có thể thêm logic hoàn % tại đây)
                Log::info("Không hoàn tiền cho lịch hẹn {$consultation->id} do hủy sát giờ (còn {$hoursUntilStart} tiếng).");
            }

            // 5. Update Status
            $consultation->status = 'cancelled';
            $consultation->save();

            // (Tùy chọn) Có thể bắn event/mail thông báo cho Chuyên gia ở đây

            return $consultation;
        });
    }
}
