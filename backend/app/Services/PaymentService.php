<?php

namespace App\Services;

use App\Models\Consultation;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Process a mock payment for a consultation.
     *
     * @param int $consultationId
     * @param string $paymentMethod
     * @return Payment
     * @throws \Exception
     */
    public function processPayment(int $consultationId, string $paymentMethod): Payment
    {
        return DB::transaction(function () use ($consultationId, $paymentMethod) {
            // Dùng lockForUpdate để tránh 2 request thanh toán cùng lúc
            $consultation = Consultation::where('id', $consultationId)->lockForUpdate()->firstOrFail();

            if ($consultation->status !== 'pending') {
                throw new \Exception('This booking is not pending payment.');
            }

            // Mock payment processing logic (e.g. charging a credit card via Stripe)
            $transactionId = 'txn_' . Str::random(12);

            $payment = Payment::create([
                'consultation_id' => $consultationId,
                'amount' => $consultation->total_price,
                'status' => 'completed',
                'payment_method' => $paymentMethod,
                'transaction_id' => $transactionId,
            ]);

            $walletService = app(\App\Services\WalletService::class);
            
            // 1. Trừ tiền từ Ví Khách Hàng (Customer)
            $walletService->withdraw(
                $consultation->customer_id, 
                (float) $consultation->total_price, 
                'payment', 
                'Payment for booking ' . $consultation->ulid, 
                $consultation
            );

            // 2. Chuyển Phí Nền Tảng cho Admin (Platform Fee)
            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin && $consultation->platform_fee > 0) {
                $walletService->deposit($admin->id, (float) $consultation->platform_fee, 'platform_fee', 'Platform fee for booking ' . $consultation->ulid, $consultation);
            }

            // 3. KHÔNG CỘNG TIỀN NGAY CHO CHUYÊN GIA Ở ĐÂY.
            // Tiền sẽ được giữ lại trên nền tảng (escrow). 
            // Job ProcessConsultantPayoutsJob sẽ chạy hàng tháng để trả cục tiền consultant_fee này.

            // Update consultation status
            $consultation->update(['status' => 'confirmed']);

            return $payment;
        });
    }
}
