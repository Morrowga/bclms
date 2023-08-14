<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class BookController
{
    public function index()
    {

        return Inertia::render(config('route.books.index'));
    }
}
