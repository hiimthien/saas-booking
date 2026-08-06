<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessPaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function process(ProcessPaymentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $payment = $this->paymentService->processPayment(
                $validated['consultation_id'],
                $validated['payment_method']
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully.',
                'data' => $payment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage(),
            ], 400);
        }
    }
}
