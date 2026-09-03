<?php

use App\Http\Controllers\GetListOfRobotsController;
use App\Http\Controllers\Robots\GetRobotsLatestEventController;

Route::prefix('robots')->group(function () {
    Route::get('', GetListOfRobotsController::class);
    Route::post('latest-positions', GetRobotsLatestEventController::class);
});