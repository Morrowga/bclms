<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;

class ProfillingSurveyController
{
    public function index()
    {
        return Inertia::render(config('route.profilling_survey.index'));
    }
}
