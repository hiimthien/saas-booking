<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        // List all transactions, latest first
        $transactions = Transaction::with('wallet.user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['success' => true, 'data' => $transactions]);
    }

    public function approve(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->type !== 'withdrawal') {
            return response()->json(['success' => false, 'message' => 'Only withdrawals can be approved.'], 422);
        }

        if ($transaction->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Transaction is already completed.'], 422);
        }

        $transaction->status = 'completed';
        $transaction->save();

        return response()->json([
            'success' => true, 
            'message' => 'Withdrawal marked as paid successfully.'
        ]);
    }
}
