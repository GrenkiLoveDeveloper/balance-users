<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Transaction;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessBalanceOperation implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public User $user;
    public $amount;
    public $type;
    public $description;

    public function __construct(User $user, float $amount, int $type, string $description)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->type = $type;
        $this->description = $description;
    }

    public function handle(): void
    {
        $user = $this->user;

        DB::transaction(function () use ($user) {
            $balance = $user->balance->balance ?? 0;

            if ($this->type === 0 && $balance < $this->amount) {
                throw new Exception('Нет денег');
            }

            $newBalance = $this->type === 1 ? $balance + $this->amount : $balance - $this->amount;

            $user->balance()->updateOrCreate([], ['balance' => $newBalance]);

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $this->amount,
                'type' => $this->type,
                'description' => $this->description,
            ]);
        });
    }
}
