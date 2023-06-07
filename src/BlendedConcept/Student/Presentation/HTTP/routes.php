<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Student\Presentation\HTTP\StudentController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('students', StudentController::class);
});


