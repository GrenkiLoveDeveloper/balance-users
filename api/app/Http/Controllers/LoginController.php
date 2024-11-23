<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginController extends Controller
{
    /**
     * Авторизация
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = [
                'login' => $request->login,
                'password' => $request->password,
                'deleted_at' => null
            ];

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => __('auth.failed')], Response::HTTP_UNAUTHORIZED);
            }

            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'message' => __('auth.success'),
                'token' => $token,
            ], Response::HTTP_OK);

        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
