<?php

use App\Http\Controllers\Events\GetRobotsLatestEventController;

Route::prefix('robots')->group(function () {
    Route::get('', GetRobotsLatestEventController::class);
});