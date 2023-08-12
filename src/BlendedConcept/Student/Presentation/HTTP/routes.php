<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Student\Presentation\HTTP\AccessibilityDeviceController;
use Src\BlendedConcept\Student\Presentation\HTTP\DisabilityDeviceController;
use Src\BlendedConcept\Student\Presentation\HTTP\StudentController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('students', StudentController::class);
    Route::resource('disability_device', DisabilityDeviceController::class);
    Route::resource('accessibility_device', AccessibilityDeviceController::class);
});
