<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Security\Presentation\HTTP\PermissionController;
use Src\BlendedConcept\Security\Presentation\HTTP\RoleController;
use Src\BlendedConcept\Security\Presentation\HTTP\UserController;
use Src\BlendedConcept\Security\Presentation\HTTP\UserExperienceSurveyController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::post('changepassword', [UserController::class, 'changePassword'])->name('changepassword');
    Route::resource('userexperiencesurvey', UserExperienceSurveyController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
});
