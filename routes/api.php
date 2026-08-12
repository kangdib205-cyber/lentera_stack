<?php

use Illuminate\Support\Facades\Route;

// API routes (modules / verticals can register additional API routes here)
Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});
