l<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\AssignRewardController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\BookController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\BookReviewController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\GameController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\PathWaysController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\RewardController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('rewards', RewardController::class);
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::resource('pathways', PathWaysController::class);
    Route::resource('bookreviews', BookReviewController::class);

    //for testing purpose, not use resource.after testing change back to resource
    // Route::get('/games', [GameController::class, 'index'])->name('games.index');
    // Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/assign_rewards', [AssignRewardController::class, 'index'])->name('assign_rewards.index');
    Route::get('/assign_rewards/create', [AssignRewardController::class, 'create'])->name('assign_rewards.create');
    Route::get('/assign_rewards/edit', [AssignRewardController::class, 'edit'])->name('assign_rewards.edit');
});
