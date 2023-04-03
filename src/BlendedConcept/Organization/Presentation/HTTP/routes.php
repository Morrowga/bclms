<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Src\BlendedConcept\Organization\Presentation\HTTP\DashboardBoardController;

Route::group(['middleware' => ['auth']], function () {

    /**
     * Dashboard view organization,superadmin,teacher
     */
    Route::get('/home',[DashboardBoardController::class,'dashboard'])->name('dashboard');

    Route::get('/organization', function () {
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Dashboard');
    })->name('dashboard.organization');
});
