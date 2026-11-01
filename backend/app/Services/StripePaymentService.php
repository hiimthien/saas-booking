<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;

class StripePaymentService
{
    public function __construct()
    {
        $apiKey = config('services.stripe.secret') ?? env('STRIPE_SECRET');
        if ($apiKey) {
            Stripe::setApiKey($apiKey);
        }
    }

    /**
     * Create a Stripe Checkout Session for Wallet Top Up
     */
    public function createTopupSession($user, $amount)
    {
        // Stripe expects amount in cents
        $amountInCents = intval($amount * 100);
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $user->email,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Wallet Top Up',
                            'description' => 'Top up balance for SaaS Consultation Platform',
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $frontendUrl . '/payment/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $frontendUrl . '/payment/cancel',
                'metadata' => [
                    'user_id' => $user->id,
                    'amount' => $amount, // store original amount in USD
                    'type' => 'topup'
                ],
            ]);

            return $session;
        } catch (\Exception $e) {
            Log::error('Stripe Top Up Session Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
