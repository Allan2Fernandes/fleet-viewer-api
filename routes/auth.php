<?php

use App\Http\Controllers\Authorization\LoginController;
use App\Http\Controllers\Authorization\LogoutController;

Route::prefix('auth')
->group(function () {
    Route::post('login', LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', LogoutController::class);
    });
});