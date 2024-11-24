<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBalanceOperation;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;

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

        // Todo: отдельный сервис
        $user = $this->getUserByLogin($login);

        if (!$user) {
            $this->error("Пользователя {$login} не найдено");
            return;
        }

        if ($amount < 0) {
            $this->error('Сумма должна быть не меньше нуля!');
            return;
        }

        $balance = $user->balance->balance ?? 0;

        if ($type === 0 && $balance < $amount) {
            $this->error('Денег нет, но вы держитесь!');
            return;
        }

        ProcessBalanceOperation::dispatch($user, $amount, $type, $description);

        $this->info('Операция проведена');

    }

    // Todo: мб вынести в репозиторий?
    /**
     * Получение пользователя
     *
     * @param string $login
     * @return User|null
     */
    private function getUserByLogin(string $login): ?User
    {
        $user = User::where('login', $login)->first();

        return $user;
    }
}
