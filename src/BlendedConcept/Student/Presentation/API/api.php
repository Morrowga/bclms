<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Student\Presentation\API\PlaylistApiController;

Route::group(['middleware' => ['auth']], function () {

    Route::get('/api/playlists/get-students', [PlaylistApiController::class, 'getStudents'])->name('playlists.getStudents');
    Route::get('/api/playlists/get-storybooks', [PlaylistApiController::class, 'getStorybooks'])->name('playlists.getStorybooks');
});
