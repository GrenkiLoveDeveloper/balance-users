<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    /**
     * Создание юзера
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'email|unique:users',
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            throw new Exception('Ошибка создания пользователя');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
        ]);

        $user->balance()->create([
            'balance' => 0,
        ]);

        return $user;
    }
}
