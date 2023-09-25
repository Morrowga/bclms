<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\BookReview\GetBookReview;

class BookReviewController
{
    public function index()
    {


        $filters = request()->only(['search', 'name', 'perPage']) ?? [];

        $bookreviews = (new GetBookReview($filters))->handle();
        return Inertia::render(config('route.bookreviews.index'),compact('bookreviews'));
    }
}
