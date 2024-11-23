<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BalanceOperationCommand extends Command
{
    protected $signature = 'balance:operate
                            {login : User login}
                            {type : 0 для списания, 1 для зачисления}
                            {amount : Сумма для операции}
                            {description : Описание операции}';

    protected $description = 'Операция с балансом для пользователя';

    public function handle(): void
    {
        $login = $this->argument('login');
        $type = (int)$this->argument('type');
        $amount = (float)$this->argument('amount');
        $description = $this->argument('description');

        $user = User::where('login', $login)->first();

        if (!$user) {
            $this->error("Пользователя {$login} не найдено");
            return;
        }

        DB::transaction(function () use ($user, $type, $amount, $description) {
            $balance = $user->balance->balance ?? 0;

            if ($type === 0 && $balance < $amount) {
                $this->error('Денег нет, но вы держитесь!');
                return;
            }

            $newBalance = $type === 1 ? $balance + $amount : $balance - $amount;

            $user->balance()->updateOrCreate([], ['balance' => $newBalance]);

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => $type,
                'description' => $description,
            ]);

            $this->info('Успех!');
        });
    }
}
