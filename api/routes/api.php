<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', LoginController::class)->middleware('guest');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/balance/{id}', [DashboardController::class, 'getData']);
    Route::get('/history', [TransactionController::class, 'getHistory']);
});
