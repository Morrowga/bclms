<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\Profiling\GetProfilingSurvey;

class ProfillingSurveyController
{
    public function index()
    {
        $survey = (new GetProfilingSurvey())->handle();

        return Inertia::render(config('route.profilling_survey.index'), [
            'survey' => $survey,
        ]);
    }
}
