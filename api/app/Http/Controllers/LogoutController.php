<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Разлогирование
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => __('auth.logout')], Response::HTTP_OK);
    }
}
