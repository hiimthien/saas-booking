<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class EarningsController extends Controller
{
    public function index(Request $request)
    {
        $profile = $request->user()->consultantProfile;
        
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Consultant profile not found.'], 404);
        }

        $wallet = \App\Models\Wallet::firstOrCreate(['user_id' => $request->user()->id]);

        // Total earnings
        $totalEarnings = \App\Models\Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'earning')
            ->sum('amount');

        // Total withdrawn
        $totalWithdrawn = \App\Models\Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'withdrawal')
            ->sum('amount'); // This is negative

        // Pending clearing (Bookings that are not yet completed, mocked as a fixed number or query)
        // Let's query upcoming bookings total price as pending
        $pendingClearing = \App\Models\Booking::whereHas('consultantProfile', function($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->where('status', 'confirmed') // Not yet completed
            ->sum('total_price');

        // Recent transactions from Wallet
        $transactions = \App\Models\Transaction::where('wallet_id', $wallet->id)
            ->with('reference') // can be consultation or payment
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_earnings' => $totalEarnings,
                'total_withdrawn' => abs($totalWithdrawn),
                'pending_clearing' => $pendingClearing,
                'available_balance' => $wallet->balance,
                'transactions' => $transactions
            ]
        ]);
    }
}
