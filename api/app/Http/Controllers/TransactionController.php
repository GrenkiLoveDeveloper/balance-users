<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Получение истории транзакций
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getHistory(Request $request): JsonResponse
    {
        $userId = $request->input('id');

        $transactions = Transaction::where('user_id', $userId)
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->input('search') . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json($transactions);
    }
}
