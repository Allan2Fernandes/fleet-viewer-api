<?php

use App\Http\Controllers\Events\CreateMockEventsController;
use App\Http\Controllers\Events\GetRobotsActiveTrendController;


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('events')->group(function () {
        Route::post('create-mock-events', CreateMockEventsController::class);
        Route::get('active-trend', GetRobotsActiveTrendController::class);
    });
});