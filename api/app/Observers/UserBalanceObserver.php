<?php

namespace App\Observers;

use App\Jobs\ProcessBalanceOperation;
use App\Models\Transaction;
use App\Models\UserBalance;
use Illuminate\Support\Facades\DB;

class UserBalanceObserver
{
    /**
     * Handle the UserBalance "created" event.
     */
    public function created(UserBalance $userBalance): void
    {
        Transaction::create([
            'user_id' => $userBalance->user_id,
            'amount' => $userBalance->balance,
            'type' => 1,
            'description' => 'Начальный баланс',
        ]);
    }

    /**
     * Handle the UserBalance "updated" event.
     */
    public function updated(UserBalance $userBalance): void
    {
        $originalBalance = $userBalance->getOriginal('balance');
        $newBalance = $userBalance->balance;

        if ($originalBalance !== $newBalance) {
            $type = $newBalance > $originalBalance ? 1 : 0;
            $amount = abs($newBalance - $originalBalance);
            $description = $type === 1 ? 'Начисление' : 'Списание';

            DB::transaction(function () use ($userBalance, $amount, $type, $description) {
                Transaction::create([
                    'user_id' => $userBalance->user_id,
                    'amount' => $amount,
                    'type' => $type,
                    'description' => $description,
                ]);
            });
        }
    }

    /**
     * Handle the UserBalance "deleted" event.
     */
    public function deleted(UserBalance $userBalance): void
    {
        //
    }

    /**
     * Handle the UserBalance "restored" event.
     */
    public function restored(UserBalance $userBalance): void
    {
        //
    }

    /**
     * Handle the UserBalance "force deleted" event.
     */
    public function forceDeleted(UserBalance $userBalance): void
    {
        //
    }
}
