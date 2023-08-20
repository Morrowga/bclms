<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class ConductLessonController
{
    public function index()
    {
        return Inertia::render(config('route.conduct_lessons.index'));
    }

    public function show()
    {
        return Inertia::render(config('route.conduct_lessons.show'));
    }
}
