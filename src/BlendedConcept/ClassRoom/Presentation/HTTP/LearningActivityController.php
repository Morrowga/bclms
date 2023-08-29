<?php

namespace Src\BlendedConcept\Classroom\Presentation\HTTP;

use Inertia\Inertia;

class LearningActivityController
{
    public function index()
    {
        return Inertia::render(config('route.learning_activities.index'));
    }
}
