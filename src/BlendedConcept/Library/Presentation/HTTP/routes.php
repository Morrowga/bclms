<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Library\Presentation\HTTP\ResourceController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/resource', ResourceController::class);

});
