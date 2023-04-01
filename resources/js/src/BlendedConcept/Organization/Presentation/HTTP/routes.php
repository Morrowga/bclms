<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', function () {
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Index');
    })->name('dashboard');
});
