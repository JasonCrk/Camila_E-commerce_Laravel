<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('auth.register');
});
