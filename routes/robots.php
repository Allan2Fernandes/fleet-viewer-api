<?php

use App\Http\Controllers\GetListOfRobotsController;
use App\Http\Controllers\Robots\GetRobotsLatestEventController;



Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('robots')->group(function () {
        Route::get('get-all-robots', GetListOfRobotsController::class);
        Route::post('latest-positions', GetRobotsLatestEventController::class);
    });
});