<?php

use App\Http\Controllers\Core\AuthController;
use Illuminate\Support\Facades\Route;

// Render our Vue 3 SPA
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::prefix('api/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
