<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\BookController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\GameController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\RewardController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('rewards', RewardController::class);

    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
});
