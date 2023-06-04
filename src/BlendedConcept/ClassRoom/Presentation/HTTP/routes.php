<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\ClassRoom\Presentation\HTTP\ClassRoomController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('classrooms', ClassRoomController::class);
});
