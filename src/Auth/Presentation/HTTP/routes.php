<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Presentation\HTTP\AuthController;

/***
 * unauthnicated access
 *
 ***/
Route::group(['middleware' => ['guest']], function () {

    Route::get("login", [AuthController::class, 'loginPage'])->name('login');
    Route::post("login", [AuthController::class, 'login'])->name('login-post');
    Route::get("verify", [AuthController::class, 'verify'])->name('verify');
    Route::get("register", [AuthController::class, 'register'])->name('register');
    Route::post("b2cstore", [AuthController::class, 'B2CStore'])->name('b2cstore');
    Route::get("verification", [AuthController::class, 'verification'])->name("verification");
    Route::get("userprofile", [DashBoardController::class, 'userProfile'])->name('userprofile');
});


/****
 *  authnicated user access
 * */
Route::group(['middleware' => ['auth']], function () {

    Route::post("logout", [AuthController::class, 'logout'])->name('logout');
});


