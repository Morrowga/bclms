<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Library\Presentation\HTTP\ResourceController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/resource', ResourceController::class);
    Route::post('/resource/request-publish/{resource}', [ResourceController::class, 'requestPublish'])->name('resource.publish');
    Route::post('/resource/approve', [ResourceController::class, 'resourceApprove'])->name('resource.approve');
    Route::post('/resource/delete', [ResourceController::class, 'resourceMultipleDelete'])->name('resource.multipledelete');
});
