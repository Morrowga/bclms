<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Teacher\Presentation\HTTP\ConductLessonController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('teachers', TeacherController::class);

    Route::get('/conduct_lessons', [ConductLessonController::class, 'index'])->name('conduct_lessons.index');
});
