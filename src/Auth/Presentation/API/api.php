<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Auth\Presentation\HTTP\AuthController;

Route::group([
    'middleware' => ['guest'],
], function () {
    Route::get('search-student-code', [AuthController::class, 'searchStudentCode'])->name('search-student-code');
});
