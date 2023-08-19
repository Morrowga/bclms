<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class LearningActivityController
{
    public function index()
    {
        return Inertia::render(config('route.learning_activities.index'));
    }
}
