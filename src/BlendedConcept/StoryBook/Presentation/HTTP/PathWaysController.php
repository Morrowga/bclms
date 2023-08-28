<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class PathWaysController
{
    public function index()
    {

        return Inertia::render(config('route.pathways.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.pathways.create'));
    }
    public function show()
    {
        return Inertia::render(config('route.pathways.show'));
    }
}
