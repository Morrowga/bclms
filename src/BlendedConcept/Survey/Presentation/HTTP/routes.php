<?php

use Illuminate\Support\Facades\Route;

use Src\BlendedConcept\Survey\Presentation\HTTP\UserExperienceSurveyController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('userexperiencesurvey', UserExperienceSurveyController::class);
});
