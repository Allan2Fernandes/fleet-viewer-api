<?php

use App\Http\Controllers\Events\CreateMockEventsController;

Route::prefix('events')->group(function () {
    Route::post('create-mock-events', CreateMockEventsController::class);
});