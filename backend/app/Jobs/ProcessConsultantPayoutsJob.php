<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Consultation;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessConsultantPayoutsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(WalletService $walletService): void
    {
        Log::info('Bắt đầu chạy tiến trình chốt lương (Payout Settlement)...');

        // Lấy tất cả ca tư vấn đã completed nhưng chưa thanh toán
        $unpaidConsultations = Consultation::where('status', 'completed')
            ->where('is_paid_out', false)
            ->get();

        if ($unpaidConsultations->isEmpty()) {
            Log::info('Không có dữ liệu cần chốt lương trong kỳ này.');
            return;
        }

        // Gom nhóm doanh thu theo chuyên gia
        $payouts = $unpaidConsultations->groupBy('consultant_profile_id');

        DB::transaction(function () use ($payouts, $unpaidConsultations, $walletService) {
            foreach ($payouts as $profileId => $consultations) {
                $totalEarnings = $consultations->sum('consultant_fee');
                
                // Lấy user_id của chuyên gia để chuyển tiền vào ví
                $consultantUserId = $consultations->first()->provider->user_id;

                if ($totalEarnings > 0) {
                    $walletService->deposit(
                        userId: $consultantUserId,
                        amount: $totalEarnings,
                        type: 'deposit',
                        description: 'Thanh toán doanh thu định kỳ cho ' . $consultations->count() . ' ca tư vấn.',
                        reference: null
                    );
                }
            }

            // Đánh dấu đã thanh toán thành công
            Consultation::whereIn('id', $unpaidConsultations->pluck('id'))->update(['is_paid_out' => true]);
        });

        Log::info('Đã hoàn tất chốt lương cho ' . $payouts->count() . ' chuyên gia.');
    }
}
