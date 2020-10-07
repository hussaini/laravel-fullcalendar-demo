<?php

use App\Http\Controllers\EventController;

Route::apiResource('events', EventController::class);
Route::model('events', Event::class);
