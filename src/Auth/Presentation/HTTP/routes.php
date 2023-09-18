<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Auth\Presentation\HTTP\AuthController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Authentication Routes
 *
 *  23.5.23
 */

//  Route::middleware([
//     'web',
//     InitializeTenancyByDomain::class,
//     PreventAccessFromCentralDomains::class,
// ])->group(function () {
//     // dd();
//     Route::get('login', [AuthController::class, 'loginPage'])->name('login');
//     // Route::get('/', function () {
//     //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
//     // });
// });

Route::group([
    'middleware' => ['guest'],
], function () {
    /**
     * Display the login page.
     * GET /login
     */
    Route::get('login', [AuthController::class, 'loginPage'])->name('login');

    Route::get('register-plan', [AuthController::class, 'planPage'])->name('registerplan');
    /**
     * Handle the login request.
     * POST /login
     */
    Route::post('login', [AuthController::class, 'login'])->name('login-post');

    /**
     * Display the verification page.
     * GET /verify
     */
    Route::get('verify', [AuthController::class, 'verify'])->name('verify');

    /**
     * Display the registration page.
     * GET /register
     */
    Route::get('register', [AuthController::class, 'register'])->name('register');

    /**
     * Register b2c user.
     * POST /b2cstore
     */
    Route::post('b2cstore', [AuthController::class, 'B2CStore'])->name('b2cstore');

    /**
     * Display the verification page.
     * GET /verification
     */
    Route::get('verification', [AuthController::class, 'verification'])->name('verification');

});

/****
 *  authnicated user access
 * */
Route::group(['middleware' => ['auth']], function () {

    /**
     *  Logout user
     *
     *  POST /logout
     */
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Display the user profile.
     * GET /userprofile
     */
    Route::get('userprofile', [AuthController::class, 'userProfile'])->name('userprofile');
});
