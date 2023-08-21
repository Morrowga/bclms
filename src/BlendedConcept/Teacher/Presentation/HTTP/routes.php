<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Teacher\Presentation\HTTP\AddCustomisationController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\ConductLessonController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\LearningActivityController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\ProfillingSurvey;
use Src\BlendedConcept\Teacher\Presentation\HTTP\SetAccessibilityController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherStorybookController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\PlayListController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\ViewStudentController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('teachers', TeacherController::class);

    Route::get('viewteacher', [TeacherController::class, 'viewteacher'])->name('viewteacher');

    Route::get('editteacher', [TeacherController::class, 'editteacher'])->name('editteacher');

    Route::get('playlists', [PlayListController::class, 'index']);

    Route::get('createplaylists', [PlayListController::class, 'create']);
    Route::get('showplaylists', [PlayListController::class, 'show']);

    Route::get('/conduct_lessons', [ConductLessonController::class, 'index'])->name('conduct_lessons.index');
    Route::get('/conduct_lessons/show', [ConductLessonController::class, 'show'])->name('conduct_lessons.show');

    Route::get('/view_students', [ViewStudentController::class, 'index'])->name('view_students.index');
    Route::get('/view_students/show', [ViewStudentController::class, 'show'])->name('view_students.show');
    Route::get('/view_students/create', [ViewStudentController::class, 'create'])->name('view_students.create');
    Route::get('/view_students/edit', [ViewStudentController::class, 'edit'])->name('view_students.edit');

    Route::get('/learning_activities', [LearningActivityController::class, 'index'])->name('learning_activities.index');

    Route::get('/profilling_survey', [ProfillingSurvey::class, 'index'])->name('profilling_survey.index');

    Route::get('/set_accessibility_device', [SetAccessibilityController::class, 'index'])->name('set_accessibility_device.index');

    Route::get('/teacher_storybook', [TeacherStorybookController::class, 'index'])->name('teacher_storybook.index');
    Route::get('/teacher_storybook/show', [TeacherStorybookController::class, 'show'])->name('teacher_storybook.show');
    Route::get('/teacher_storybook/assign_student', [TeacherStorybookController::class, 'assign_student'])->name('teacher_storybook.assign_student');

    Route::get('/add_customisation/create', [AddCustomisationController::class, 'create'])->name('add_customisation.create');
    Route::get('/add_customisation/edit', [AddCustomisationController::class, 'edit'])->name('add_customisation.edit');
});
