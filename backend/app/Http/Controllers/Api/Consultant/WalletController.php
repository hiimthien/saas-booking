<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Http\Requests\TopupWalletRequest;

class WalletController extends Controller
{
    /**
     * Get the authenticated user's wallet balance.
     */
    public function getBalance(Request $request)
    {
        $wallet = Wallet::firstOrCreate(['user_id' => $request->user()->id]);
        
        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $wallet->balance
            ]
        ]);
    }

    /**
     * Get the authenticated user's transaction history.
     */
    public function getTransactions(Request $request)
    {
        $wallet = Wallet::firstOrCreate(['user_id' => $request->user()->id]);
        
        $transactions = Transaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    /**
     * Get aggregated chart data (revenue over last 30 days)
     */
    public function getChartData(Request $request)
    {
        $wallet = Wallet::firstOrCreate(['user_id' => $request->user()->id]);
        
        // Only count earnings or platform fees for revenue chart
        $type = $request->user()->role === 'admin' ? 'platform_fee' : 'earning';

        $thirtyDaysAgo = now()->subDays(30);

        $chartData = Transaction::where('wallet_id', $wallet->id)
            ->where('type', $type)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Fill in missing days with 0
        $filledData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $existing = $chartData->firstWhere('date', $date);
            $filledData[] = [
                'date' => $date,
                'total' => $existing ? (float) $existing->total : 0
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $filledData
        ]);
    }

    /**
     * Top up a wallet. Uses Stripe Checkout if STRIPE_SECRET is configured.
     * Otherwise, falls back to mock top up for local testing.
     */
    public function topup(TopupWalletRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        
        // If Stripe is configured, use it
        if (env('STRIPE_SECRET')) {
            $stripeService = app(\App\Services\StripePaymentService::class);
            $session = $stripeService->createTopupSession($user, $validated['amount']);
            
            return response()->json([
                'success' => true,
                'checkout_url' => $session->url
            ]);
        }

        // Fallback for local testing without Stripe keys
        $walletService = app(\App\Services\WalletService::class);
        $transaction = $walletService->deposit(
            $user->id, 
            $validated['amount'], 
            'top_up', 
            'Top up via Mock System'
        );

        return response()->json([
            'success' => true,
            'message' => 'Wallet topped up successfully (Mocked)',
            'data' => $transaction
        ]);
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_account' => 'required|string',
        ]);

        $wallet = Wallet::firstOrCreate(['user_id' => $request->user()->id]);
        $amount = $request->amount;

        if ($wallet->balance < $amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient funds.'], 422);
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($wallet, $amount, $request) {
            $wallet->balance -= $amount;
            $wallet->save();

            \App\Models\Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => -$amount,
                'type' => 'withdrawal',
                'status' => 'pending', // Requires admin approval
                'description' => 'Withdrawal to ' . $request->bank_account
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal request submitted successfully.',
            'balance' => $wallet->balance
        ]);
    }
}
