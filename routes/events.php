<?php

use App\Http\Controllers\Events\CreateMockEventsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('events')->group(function () {
        Route::post('create-mock-events', CreateMockEventsController::class);
    });
});