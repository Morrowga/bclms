<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationStudentController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationTeacherController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('organizations', OrganizationController::class);
    Route::get('organizations/{organization}/addsubscription', [OrganizationController::class, 'addSubscription'])->name('organizations.addSubscription');
    Route::put('organizations/{organization}/storesubscription', [OrganizationController::class, 'storeSubscription'])->name('organizations.storeSubscription');

    Route::resource('/organizations-teacher', OrganizationTeacherController::class);

    Route::resource('/organizations-student', OrganizationStudentController::class);

});
