<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Survey\Presentation\HTTP\ProfillingSurveyController;
use Src\BlendedConcept\Survey\Presentation\HTTP\SurveyResultController;
use Src\BlendedConcept\Survey\Presentation\HTTP\UserExperienceSurveyController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('userexperiencesurvey', UserExperienceSurveyController::class);
    Route::get('/survey_results', [SurveyResultController::class, 'index'])->name('survey_results.index');
    Route::get('/survey_results/show', [SurveyResultController::class, 'show'])->name('survey_results.show');
    Route::get('/survey_results/view', [SurveyResultController::class, 'view'])->name('survey_results.view');
    Route::get('/profilling_survey', [ProfillingSurveyController::class, 'index'])->name('profilling_survey.index');
});
