<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\ClassRoom\Presentation\HTTP\ClassRoomController;
use Src\BlendedConcept\Classroom\Presentation\HTTP\ConductLessonController;
use Src\BlendedConcept\Classroom\Presentation\HTTP\LearningActivityController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('classrooms', ClassRoomController::class);
    Route::get('/classroom-show-copy', [ClassRoomController::class, 'showCopy'])->name('showCopy');
    Route::get('/classroom-edit-copy', [ClassRoomController::class, 'editCopy'])->name('editCopy');

    Route::get('/classroom/org-teacher', [ClassRoomController::class, 'orgTeacherIndex'])->name('org-teacher-classroom.index');
    Route::get('/classroom/org-teacher/create', [ClassRoomController::class, 'orgTeacherCreate'])->name('org-teacher-classroom.create');
    Route::get('/classroom/org-teacher/edit', [ClassRoomController::class, 'orgTeacherEdit'])->name('org-teacher-classroom.edit');
    Route::get('/classroom/org-teacher/show', [ClassRoomController::class, 'orgTeacherShow'])->name('org-teacher-classroom.show');
    Route::get('/classroom/org-teacher/add-group', [ClassRoomController::class, 'orgTeacherAddGroup'])->name('org-teacher-classroom.add-group');
    Route::get('/classroom/org-teacher/edit-group', [ClassRoomController::class, 'orgTeacherEditGroup'])->name('org-teacher-classroom.edit-group');

    Route::get('/conduct_lessons', [ConductLessonController::class, 'index'])->name('conduct_lessons.index');
    Route::get('/conduct_lessons/show', [ConductLessonController::class, 'show'])->name('conduct_lessons.show');

    Route::get('/learning_activities', [LearningActivityController::class, 'index'])->name('learning_activities.index');
});
