<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Library\Presentation\HTTP\ResourceController;


Route::group(['middleware' => ['auth']], function () {

    Route::get('/resource', [ResourceController::class, 'index'])->name('resource');
    // Route::get("dfsasfdfds",function(){
    //     dd("hello");
    // });

});
