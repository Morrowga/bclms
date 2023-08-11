<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;
use Src\BlendedConcept\Organization\Presentation\HTTP\PlanController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('organizations', OrganizationController::class);
    Route::get('/organizations/edit', [OrganizationController::class, 'testEdit'])->name('organizations.test.edit');

    // Route::resource('plans', PlanController::class);

    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('/plans/show', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/plans/orgcreate', [PlanController::class, 'planfororg'])->name('planfororg.show');

    // Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
    // Route::get('/organizations/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
    // Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    // Route::get('/organizations/show', [OrganizationController::class, 'show'])->name('organizations.show');
});
