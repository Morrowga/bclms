<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\ClassRoom\Presentation\API\ClassroomApiController;

Route::group(['middleware' => ['auth']], function () {

    Route::get('/api/classrooms/get-students', [ClassroomApiController::class, 'getStudents'])->name('classrooms.getStudents');
    Route::get('/api/classrooms/get-teachers', [ClassroomApiController::class, 'getTeachers'])->name('classrooms.getTeachers');
});
