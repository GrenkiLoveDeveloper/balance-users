<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Получение данных
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(int|string $id): JsonResponse
    {
        $user = User::with([
            'balance',
            'transactions' => fn ($query) => $query->latest()->take(5)
        ])->findOrFail($id);

        $balance = $user->balance->balance ?? 0;

        return response()->json([
            'balance' => $balance,
            'transactions' => $user->transactions,
        ]);
    }
}
