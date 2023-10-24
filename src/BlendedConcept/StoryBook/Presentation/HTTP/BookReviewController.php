<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\BookReview\GetBookReview;
use Src\BlendedConcept\StoryBook\Domain\Policies\BookReviewPolicy;

class BookReviewController
{
    public function index()
    {

        abort_if(authorize('view', BookReviewPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = request()->only(['search', 'name', 'perPage']) ?? [];

        $bookreviews = (new GetBookReview($filters))->handle();

        return Inertia::render(config('route.bookreviews.index'), compact('bookreviews'));
    }
}
