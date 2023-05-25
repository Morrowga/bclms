<?php

use Illuminate\Support\Facades\Route;

use Src\BlendedConcept\User\Presentation\HTTP\NotificationController;
use Src\BlendedConcept\User\Presentation\HTTP\PermissionController;
use Src\BlendedConcept\User\Presentation\HTTP\RoleController;
use Src\BlendedConcept\User\Presentation\HTTP\UserController;


Route::group(['middleware' => ['auth']], function () {
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::post('changepassword', [UserController::class,'changePassword'])->name('changepassword');


    //mark as read with id
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name("markAsRead");

    //mark as read all
    Route::post('/notifications/readall', [NotificationController::class, 'readAll'])->name("markAsReadAll");

    //get all notifications
    Route::get('/notifications/index', [NotificationController::class, "getAllNotifications"])->name("notifications");

});
