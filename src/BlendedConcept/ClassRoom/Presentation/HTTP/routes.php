<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\ClassRoom\Presentation\HTTP\ClassRoomController;
use Src\BlendedConcept\Classroom\Presentation\HTTP\ConductLessonController;
use Src\BlendedConcept\Classroom\Presentation\HTTP\LearningActivityController;

Route::group(['middleware' => ['auth']], function () {

    //org admin classroom
    Route::resource('classrooms', ClassRoomController::class);
    Route::get('/classroom-show-copy/{classroom}', [ClassRoomController::class, 'showCopy'])->name('showCopy');
    Route::get('/classroom-edit-copy/{classroom}', [ClassRoomController::class, 'editCopy'])->name('editCopy');

    //org teacher classroom
    Route::get('/classroom/org-teacher', [ClassRoomController::class, 'orgTeacherIndex'])->name('org-teacher-classroom.index');
    Route::get('/classroom/org-teacher/create', [ClassRoomController::class, 'orgTeacherCreate'])->name('org-teacher-classroom.create');
    Route::get('/classroom/org-teacher/edit', [ClassRoomController::class, 'orgTeacherEdit'])->name('org-teacher-classroom.edit');
    Route::get('/classroom/org-teacher/{classroom}/show', [ClassRoomController::class, 'orgTeacherShow'])->name('org-teacher-classroom.show');

    //add group
    Route::get('/classroom/org-teacher/{classroom}/add-group', [ClassRoomController::class, 'orgTeacherAddGroup'])->name('org-teacher-classroom.add-group');
    Route::post('/classroom/org-teacher/store-group', [ClassRoomController::class, 'orgTeacherStoreGroup'])->name('org-teacher-classroom.store-group');
    Route::get('/classroom/org-teacher/{classroom_group}/edit-group', [ClassRoomController::class, 'orgTeacherEditGroup'])->name('org-teacher-classroom.edit-group');
    Route::put('/classroom/org-teacher/{classroom_group}/update-group', [ClassRoomController::class, 'orgTeacherUpdateGroup'])->name('org-teacher-classroom.update-group');
    Route::delete('/classroom/org-teacher/{classroom_group}/delete-group', [ClassRoomController::class, 'orgTeacherDeleteGroup'])->name('org-teacher-classroom.delete-group');

    //conduct lesson
    Route::get('/conduct_lessons', [ConductLessonController::class, 'index'])->name('conduct_lessons.index');
    Route::get('/conduct_lessons/show', [ConductLessonController::class, 'show'])->name('conduct_lessons.show');

    Route::get('/learning_activities', [LearningActivityController::class, 'index'])->name('learning_activities.index');
});
