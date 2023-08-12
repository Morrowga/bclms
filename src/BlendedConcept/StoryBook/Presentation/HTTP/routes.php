<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\RewardController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('rewards', RewardController::class);
});
