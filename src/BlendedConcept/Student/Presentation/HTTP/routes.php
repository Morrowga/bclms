<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Student\Presentation\HTTP\PlayListController;
use Src\BlendedConcept\Student\Presentation\HTTP\ProfilingSurveyController;
use Src\BlendedConcept\Student\Presentation\HTTP\StudentController;
use Src\BlendedConcept\Student\Presentation\HTTP\TeacherStudentController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('students', StudentController::class);
    Route::resource('playlists', PlayListController::class);

    // Route::get('createplaylists', [PlayListController::class, 'create'])->name('createplaylists');
    // Route::get('editplaylists', [PlayListController::class, 'edit'])->name('editplaylists');
    // Route::get('showplaylists', [PlayListController::class, 'show'])->name('showplaylists');

    Route::resource('/teacher_students', TeacherStudentController::class);
    Route::get('/teacher_student/kidmode/{user}', [TeacherStudentController::class, 'kidMode'])->name('teacher_students.kidmode');
    Route::post('/teacher_student/exitmode/{user}', [TeacherStudentController::class, 'exitMode'])->name('teacher_students.exitmode');

    Route::get('/teacher_student/profiling_surveys', [ProfilingSurveyController::class, 'index'])->name('teacher_students.profiling_surveys');
    // Route::get('/view_students/show', [ViewStudentController::class, 'show'])->name('view_students.show');
    // Route::get('/view_students/create', [ViewStudentController::class, 'create'])->name('view_students.create');
    // Route::get('/view_students/edit', [ViewStudentController::class, 'edit'])->name('view_students.edit');
    // Route::resource('accessibility_device', AccessibilityDeviceController::class);
});
