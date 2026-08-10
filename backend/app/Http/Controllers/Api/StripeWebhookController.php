<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;
use App\Services\WalletService;

class StripeWebhookController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe Webhook Error: Invalid Payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid Signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            default:
                Log::info('Unhandled Stripe Event Type: ' . $event->type);
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        // Extract metadata
        $metadata = $session->metadata;
        
        if (isset($metadata->type) && $metadata->type === 'topup') {
            $userId = $metadata->user_id;
            $amount = $metadata->amount;

            try {
                $this->walletService->deposit(
                    $userId,
                    $amount,
                    'top_up',
                    'Top up via Stripe (Session: ' . $session->id . ')'
                );
                Log::info("Successfully credited wallet for User ID {$userId} with amount {$amount}.");
            } catch (\Exception $e) {
                Log::error('Error processing Stripe topup for User ID ' . $userId . ': ' . $e->getMessage());
            }
        }
    }
}
