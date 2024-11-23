<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Учетка тестовая
     *
     * @return void
     */
    public function run(): void
    {
        Log::info('UsersTableSeeder run method called');

        User::create([
             'name' => 'Admin',
             'login' => 'Admin',
             'password' => Hash::make('12345'),
             'email' => 'test@test.com',
         ]);

        Log::info('User created');
    }
}
