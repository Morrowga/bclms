<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\User\Presentation\HTTP\PermissionController;
use Src\BlendedConcept\User\Presentation\HTTP\PortalController;
use Src\BlendedConcept\User\Presentation\HTTP\RoleController;
use Src\BlendedConcept\User\Presentation\HTTP\UserController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
Route::get('/', [PortalController::class, 'index'])->name('portal');
