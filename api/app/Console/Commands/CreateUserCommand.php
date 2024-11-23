<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create
                            {name : Name}
                            {email : Email}
                            {login : Логин}
                            {password : Пароль}';

    protected $description = 'Создание нового пользователя';

    public function handle(): void
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $login = $this->argument('login');
        $password = $this->argument('password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'login' => $login,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'email|unique:users',
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            $this->error('Ошибка создания пользователя:');
            foreach ($validator->messages()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'login' => $login,
            'password' => Hash::make($password),
        ]);

        $this->info("Пользователь {$user->name} успешно создан! Используйте логин {$user->login} для авторизации на сайте");
    }
}
