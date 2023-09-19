<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Security\Presentation\HTTP\PermissionController;
use Src\BlendedConcept\Security\Presentation\HTTP\RoleController;
use Src\BlendedConcept\Security\Presentation\HTTP\UserController;
use Src\BlendedConcept\Security\Presentation\HTTP\UserProfileController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::post('changepassword', [UserController::class, 'changePassword'])->name('changepassword');

    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);

    Route::put('/users/{user}/change_status', [UserController::class, 'changeStatus'])->name('users.change_status');

    // user profile
    Route::get('userprofile', [UserProfileController::class, 'index'])->name('userprofile');
    Route::post('userprofile/update', [UserProfileController::class, 'updateProfile'])->name('userprofile.update');
    Route::post('userprofile/changepassword', [UserProfileController::class, 'changePassword'])->name('userprofile.changepassword');
});
