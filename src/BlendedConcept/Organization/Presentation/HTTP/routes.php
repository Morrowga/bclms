<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Src\BlendedConcept\Organization\Presentation\HTTP\DashboardBoardController;

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

    Route::get('/organization', function () {
        return "hello world";
    })->name('dashboard.organization');
});
