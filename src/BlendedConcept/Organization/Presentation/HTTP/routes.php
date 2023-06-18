<?php

use Illuminate\Support\Facades\Route;

use Src\BlendedConcept\Organization\Presentation\HTTP\PlanController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;


Route::group(['middleware' => ['auth']], function () {

    Route::resource('organizations', OrganizationController::class);

    Route::resource('plans', PlanController::class)->only(['store', 'index', 'show', 'destroy']);

});
