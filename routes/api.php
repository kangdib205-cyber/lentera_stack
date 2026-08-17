<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// API routes (modules / verticals can register additional API routes here)
Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});

// Authentication (uses web middleware so session/cookie auth works)
Route::middleware('web')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
});
