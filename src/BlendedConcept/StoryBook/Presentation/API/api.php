<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\StoryBook\Presentation\HTTP\Api\LandingPageController;

Route::get('landingpage', [LandingPageController::class, 'index'])->name('landingpage');
