<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Survey\Presentation\HTTP\QuestionController;
use Src\BlendedConcept\Survey\Presentation\HTTP\SurveyResponseController;
use Src\BlendedConcept\Survey\Presentation\HTTP\ProfillingSurveyController;
use Src\BlendedConcept\Survey\Presentation\HTTP\UserExperienceSurveyController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('userexperiencesurvey', UserExperienceSurveyController::class);
    Route::resource('questions', QuestionController::class);
    Route::get('/profilling_survey', [ProfillingSurveyController::class, 'index'])->name('profilling_survey.index');
    Route::post('/profilling_survey/{profilingSurvey}', [ProfillingSurveyController::class, 'saveOrder'])->name('profilling_survey.order-saving');
    Route::resource('/surveyresponse', SurveyResponseController::class);
    Route::get('/userexperiencesurvey/view/{survey}', [UserExperienceSurveyController::class, 'view'])->name('userexperiencesurvey.view');
});
