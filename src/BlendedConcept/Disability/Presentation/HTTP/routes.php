<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Disability\Presentation\HTTP\AccessibilityDeviceController;
use Src\BlendedConcept\Disability\Presentation\HTTP\DisabilityDeviceController;
use Src\BlendedConcept\Disability\Presentation\HTTP\LearningNeedController;
use Src\BlendedConcept\Disability\Presentation\HTTP\SetAccessibilityController;
use Src\BlendedConcept\Disability\Presentation\HTTP\ThemeController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('disability_type', DisabilityDeviceController::class);
    Route::resource('disability_themes', ThemeController::class);
    Route::resource('learning_need', LearningNeedController::class);
    Route::resource('accessibility_device', AccessibilityDeviceController::class);
    // Route::get('/accessibility_device', [AccessibilityDeviceController::class, 'index'])->name('accessibility_device.index');
    // Route::get('/accessibility_device/edit', [AccessibilityDeviceController::class, 'edit'])->name('accessibility_device.edit');
    // Route::get('/accessibility_device/create', [AccessibilityDeviceController::class, 'create'])->name('accessibility_device.create');
    // Route::get('/accessibility_device/show', [AccessibilityDeviceController::class, 'show'])->name('accessibility_device.show');

    Route::get('/set_accessibility_device/{student_id}', [SetAccessibilityController::class, 'index'])->name('set_accessibility_device.index');
    Route::post('/set_accessibility_device/{student_id}', [SetAccessibilityController::class, 'store'])->name('set_accessibility_device.store');
});
