<?php

use App\Http\Controllers\Events\CreateDataForExistingFleetController;
use App\Http\Controllers\Events\CreateMockEventsController;
use App\Http\Controllers\Events\GetRobotsActiveTrendController;


Route::middleware(['auth:sanctum', 'token-extension'])->group(function () {
    Route::prefix('events')->group(function () {
        Route::post('create-mock-events', CreateMockEventsController::class);
        Route::get('active-trend', GetRobotsActiveTrendController::class);
        Route::post('create-mock-data', CreateDataForExistingFleetController::class);
    });
});