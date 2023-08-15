<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class BookReviewController
{
    public function index()
    {

        return Inertia::render(config('route.bookreviews.index'));
    }
}
