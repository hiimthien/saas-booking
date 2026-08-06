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

        // Mock payment processing logic
        $transactionId = 'txn_' . Str::random(12);

        $payment = Payment::create([
            'consultation_id' => $consultationId,
            'amount' => $consultation->total_price,
            'status' => 'completed',
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
        ]);

        // Update consultation status
        $consultation->update(['status' => 'confirmed']);

        return $payment;
    }
}
