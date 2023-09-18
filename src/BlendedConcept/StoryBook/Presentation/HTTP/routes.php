<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\AssignRewardController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\BookController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\BookReviewController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\GameController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\PathwayController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\RewardController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\StudentGamesController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\StudentRewardsController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\StudentStoryBookController;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\TeacherStorybookController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('rewards', RewardController::class);

    Route::post('changerewardStatus/{reward}', [RewardController::class, 'changerewardStatus'])->name('changerewardStatus');
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::resource('pathways', PathwayController::class);
    Route::resource('bookreviews', BookReviewController::class);

    //for testing purpose, not use resource.after testing change back to resource
    // Route::get('/games', [GameController::class, 'index'])->name('games.index');
    // Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/teacher_storybook', [TeacherStorybookController::class, 'index'])->name('teacher_storybook.index');
    Route::get('/teacher_storybook/edit', [TeacherStorybookController::class, 'edit'])->name('teacher_storybook.edit');
    Route::get('/teacher_storybook/show', [TeacherStorybookController::class, 'show'])->name('teacher_storybook.show');
    Route::get('/teacher_storybook/assign_student', [TeacherStorybookController::class, 'assign_student'])->name('teacher_storybook.assign_student');

    Route::get('/assign_rewards', [AssignRewardController::class, 'index'])->name('assign_rewards.index');
    Route::get('/assign_rewards/create', [AssignRewardController::class, 'create'])->name('assign_rewards.create');
    Route::get('/assign_rewards/edit', [AssignRewardController::class, 'edit'])->name('assign_rewards.edit');

    Route::get('storybooks', [StudentStoryBookController::class, 'index'])->name('storybooks');
    Route::get('storybooks/show', [StudentStoryBookController::class, 'show'])->name('storybooks.show');
    Route::get('storybooks/pathway', [StudentStoryBookController::class, 'pathway'])->name('storybooks.pathway');
    Route::get('student-games', [StudentGamesController::class, 'index'])->name('student-games');
    Route::get('game/show', [StudentGamesController::class, 'show'])->name('games.show');
    Route::get('student-rewards', [StudentRewardsController::class, 'index'])->name('student-rewards');
    Route::get('reward-store', [StudentRewardsController::class, 'store'])->name('reward-store');
    Route::get('be-lucky', [StudentRewardsController::class, 'beLucky'])->name('be-lucky');
    Route::get('buy-sticker', [StudentRewardsController::class, 'buySticker'])->name('buy-sticker');
});
