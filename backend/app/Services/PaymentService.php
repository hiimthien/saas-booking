<?php

namespace App\Services;

use App\Models\Consultation;
use App\Models\Payment;
use Illuminate\Support\Str;

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
        $consultation = Consultation::findOrFail($consultationId);

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
        
        // 1. Deduct from Customer (Client)
        $walletService->withdraw(
            $consultation->customer_id, 
            (float) $consultation->total_price, 
            'payment', 
            'Payment for booking ' . $consultation->ulid, 
            $consultation
        );

        // 2. Distribute to Admin (Platform Fee)
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin && $consultation->platform_fee > 0) {
            $walletService->deposit($admin->id, (float) $consultation->platform_fee, 'platform_fee', 'Platform fee for booking ' . $consultation->ulid, $consultation);
        }

        // 3. Distribute to Consultant (Earnings)
        $consultant = $consultation->consultantProfile->user;
        if ($consultant && $consultation->consultant_fee > 0) {
            $walletService->deposit($consultant->id, (float) $consultation->consultant_fee, 'earning', 'Earnings for booking ' . $consultation->ulid, $consultation);
        }

        // Update consultation status
        $consultation->update(['status' => 'confirmed']);

        return $payment;
    }
}
