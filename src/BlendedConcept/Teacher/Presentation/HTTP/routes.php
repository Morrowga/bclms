<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Teacher\Presentation\HTTP\AddCustomisationController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('teachers', TeacherController::class);

    Route::get('viewteacher', [TeacherController::class, 'viewteacher'])->name('viewteacher');

    Route::get('editteacher', [TeacherController::class, 'editteacher'])->name('editteacher');
    Route::get('/add_customisation/create', [AddCustomisationController::class, 'create'])->name('add_customisation.create');
    Route::get('/add_customisation/edit', [AddCustomisationController::class, 'edit'])->name('add_customisation.edit');

    Route::get('listoforgteacher', [TeacherController::class, 'listofteacher'])->name('listoforgteacher');

    Route::post('/teacher/import', [TeacherController::class, 'import_excel'])->name('teachers.import');
});
