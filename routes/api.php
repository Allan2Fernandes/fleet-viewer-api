<?php

require __DIR__ . '/auth.php';
require __DIR__ . '/robots.php';
require __DIR__ . '/events.php';

Route::get('deployment-test', fn() => response()->json(['message' => 'Response from Backend']));