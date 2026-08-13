<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\Eloquent\Model;

class WalletService
{
    /**
     * Get or create a wallet for the given user.
     */
    public function getWallet(int $userId): Wallet
    {
        return Wallet::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Add money to a user's wallet.
     */
    public function deposit(int $userId, float $amount, string $type, ?string $description = null, ?Model $reference = null): Transaction
    {
        if ($amount <= 0) {
            throw new Exception("Deposit amount must be greater than zero.");
        }

        DB::beginTransaction();
        try {
            // Get or create wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
            
            // 1. Lock for update to prevent race conditions during concurrent requests
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            // 2. Update balance
            $wallet->balance += $amount;
            $wallet->save();

            // 3. Insert transaction history
            $transaction = new Transaction([
                'wallet_id' => $wallet->id,
                'type' => $type,
                'amount' => $amount,
                'description' => $description,
            ]);

            if ($reference) {
                $transaction->reference()->associate($reference);
            }

            $transaction->save();

            // 4. Commit if both wallet update and transaction insert succeed
            DB::commit();

            return $transaction;
        } catch (Exception $e) {
            // 5. Rollback everything if any step fails
            DB::rollBack();
            Log::error('Wallet Deposit Error: ' . $e->getMessage(), [
                'user_id' => $userId,
                'amount' => $amount,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Deduct money from a user's wallet.
     */
    public function withdraw(int $userId, float $amount, string $type, ?string $description = null, ?Model $reference = null): Transaction
    {
        if ($amount <= 0) {
            throw new Exception("Withdrawal amount must be greater than zero.");
        }

        DB::beginTransaction();
        try {
            // Get or create wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
            
            // 1. Lock for update
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            // 2. Check sufficient funds after acquiring the lock
            if ($wallet->balance < $amount) {
                throw new Exception("Insufficient funds. Current balance: {$wallet->balance}");
            }

            // 3. Update balance
            $wallet->balance -= $amount;
            $wallet->save();

            // 4. Insert transaction history
            $transaction = new Transaction([
                'wallet_id' => $wallet->id,
                'type' => $type,
                'amount' => -$amount, // Save as negative
                'description' => $description,
            ]);

            if ($reference) {
                $transaction->reference()->associate($reference);
            }

            $transaction->save();

            // 5. Commit
            DB::commit();

            return $transaction;
        } catch (Exception $e) {
            // 6. Rollback
            DB::rollBack();
            Log::error('Wallet Withdraw Error: ' . $e->getMessage(), [
                'user_id' => $userId,
                'amount' => $amount,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
