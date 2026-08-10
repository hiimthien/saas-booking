<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
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

        return DB::transaction(function () use ($userId, $amount, $type, $description, $reference) {
            $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
            
            // Lock for update to prevent race conditions
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            $wallet->balance += $amount;
            $wallet->save();

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

            return $transaction;
        });
    }

    /**
     * Deduct money from a user's wallet.
     */
    public function withdraw(int $userId, float $amount, string $type, ?string $description = null, ?Model $reference = null): Transaction
    {
        if ($amount <= 0) {
            throw new Exception("Withdrawal amount must be greater than zero.");
        }

        return DB::transaction(function () use ($userId, $amount, $type, $description, $reference) {
            $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
            
            // Lock for update
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            if ($wallet->balance < $amount) {
                throw new Exception("Insufficient funds. Current balance: {$wallet->balance}");
            }

            $wallet->balance -= $amount;
            $wallet->save();

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

            return $transaction;
        });
    }
}
