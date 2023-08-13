<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Student\Presentation\HTTP\AccessibilityDeviceController;
use Src\BlendedConcept\Student\Presentation\HTTP\DisabilityDeviceController;
use Src\BlendedConcept\Student\Presentation\HTTP\StudentController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('students', StudentController::class);
    Route::resource('disability_device', DisabilityDeviceController::class);
    // Route::resource('accessibility_device', AccessibilityDeviceController::class);

    Route::get('/accessibility_device', [AccessibilityDeviceController::class, 'index'])->name('accessibility_device.index');
    Route::get('/accessibility_device/edit', [AccessibilityDeviceController::class, 'edit'])->name('accessibility_device.edit');
    Route::get('/accessibility_device/create', [AccessibilityDeviceController::class, 'create'])->name('accessibility_device.create');
    Route::get('/accessibility_device/show', [AccessibilityDeviceController::class, 'show'])->name('accessibility_device.show');
});
