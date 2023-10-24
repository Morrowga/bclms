<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Organisation\Presentation\HTTP\OrganisationController;
use Src\BlendedConcept\Organisation\Presentation\HTTP\OrganisationStudentController;
use Src\BlendedConcept\Organisation\Presentation\HTTP\OrganisationTeacherController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('organisations', OrganisationController::class);
    Route::get('/staff_organisations', [OrganisationController::class, 'staff_index'])->name('staff_organisations');
    Route::get('organisations/{organisation}/addsubscription', [OrganisationController::class, 'addSubscription'])->name('organisations.addSubscription');
    Route::put('organisations/{organisation}/storesubscription', [OrganisationController::class, 'storeSubscription'])->name('organisations.storeSubscription');

    Route::resource('/organisations-teacher', OrganisationTeacherController::class);
    Route::resource('organisations-student', OrganisationStudentController::class);
});
