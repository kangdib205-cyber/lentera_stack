<?php

use Illuminate\Support\Facades\Route;

// Core domain routes
Route::get('/core/health', function () {
    return response('core ok');
});
