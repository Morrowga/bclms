<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\System\Presentation\HTTP\DashBoardController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/get-recent-organisations', [DashBoardController::class, 'getRecentOrganisations'])->name('admin.get-recent-organisations');
    Route::get('/admin/get-recent-users', [DashBoardController::class, 'getRecentUsers'])->name('admin.get-recent-users');
});
