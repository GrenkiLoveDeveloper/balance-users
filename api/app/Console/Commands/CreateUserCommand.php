<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UserService;
use Exception;

class CreateUserCommand extends Command
{
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }
    protected $signature = 'user:create
                            {name : Name}
                            {email : Email}
                            {login : Логин}
                            {password : Пароль}';

    protected $description = 'Создание нового пользователя';

    /**
     * @return void
     */
    public function handle(): void
    {
        $data = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'login' => $this->argument('login'),
            'password' => $this->argument('password'),
        ];

        try {
            $user = $this->userService->createUser($data);
            $this->info("Пользователь {$user->name} успешно создан! Используйте логин {$user->login} для авторизации на сайте");
        } catch (Exception $e) {
            $this->error('Ошибка создания пользователя:');
            $this->error($e->getMessage());
        }
    }
}
