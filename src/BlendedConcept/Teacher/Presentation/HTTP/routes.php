<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('teachers', TeacherController::class);
});
