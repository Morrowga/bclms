<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class ProfillingSurvey
{
    public function index()
    {
        return Inertia::render(config('route.profilling_survey.index'));
    }
}
