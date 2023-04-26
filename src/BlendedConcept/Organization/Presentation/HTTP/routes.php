<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Src\BlendedConcept\Organization\Presentation\HTTP\DashboardBoardController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;
use Src\BlendedConcept\Organization\Presentation\HTTP\PlanController;

Route::get('/', function () {
    return redirect('/bc/index');
});
Route::get('/admin', function () {
    return redirect('/home');
});
Route::group(['middleware' => ['auth']], function () {

    /**
     * Dashboard view organization,superadmin,teacher
     */
    Route::get('/home', [DashboardBoardController::class, 'superAdminDashboard'])->name('dashboard');
    Route::resource('organizations', OrganizationController::class);
    Route::resource('plans', PlanController::class);
});
