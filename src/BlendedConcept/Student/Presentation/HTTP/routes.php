<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Student\Presentation\HTTP\GamesController;
use Src\BlendedConcept\Student\Presentation\HTTP\RewardsController;
use Src\BlendedConcept\Student\Presentation\HTTP\StudentController;
use Src\BlendedConcept\Student\Presentation\HTTP\StoryBookController;
use Src\BlendedConcept\Student\Presentation\HTTP\DisabilityDeviceController;
use Src\BlendedConcept\Student\Presentation\HTTP\AccessibilityDeviceController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('students', StudentController::class);
    Route::resource('disability_device', DisabilityDeviceController::class);
    Route::get('storybooks', [StoryBookController::class, 'index'])->name('storybooks');
    Route::get('storybooks/show', [StoryBookController::class, 'show'])->name('storybooks.show');
    Route::get('student-games', [GamesController::class, 'index'])->name('student-games');
    Route::get('game/show', [GamesController::class, 'show'])->name('games.show');
    Route::get('student-rewards', [RewardsController::class, 'index'])->name('student-rewards');
    Route::get('reward-store', [RewardsController::class, 'store'])->name('reward-store');
    Route::get('be-lucky', [RewardsController::class, 'beLucky'])->name('be-lucky');
    Route::get('buy-sticker', [RewardsController::class, 'buySticker'])->name('buy-sticker');
    // Route::resource('accessibility_device', AccessibilityDeviceController::class);

    Route::get('/accessibility_device', [AccessibilityDeviceController::class, 'index'])->name('accessibility_device.index');
    Route::get('/accessibility_device/edit', [AccessibilityDeviceController::class, 'edit'])->name('accessibility_device.edit');
    Route::get('/accessibility_device/create', [AccessibilityDeviceController::class, 'create'])->name('accessibility_device.create');
    Route::get('/accessibility_device/show', [AccessibilityDeviceController::class, 'show'])->name('accessibility_device.show');
});
