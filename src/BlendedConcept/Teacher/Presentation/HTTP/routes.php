<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Teacher\Presentation\HTTP\ConductLessonController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\PlayListController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('teachers', TeacherController::class);

    Route::get("viewteacher",[TeacherController::class,'viewteacher'])->name('viewteacher');
    Route::get("editteacher",[TeacherController::class,'editteacher'])->name('editteacher');

    Route::get('playlists',[PlayListController::class,'index']);

    Route::get('/conduct_lessons', [ConductLessonController::class, 'index'])->name('conduct_lessons.index');
});
