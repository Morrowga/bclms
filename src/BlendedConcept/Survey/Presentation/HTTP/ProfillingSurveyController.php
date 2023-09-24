<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Survey\Domain\Policies\SurveyPolicy;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\Profiling\GetProfilingSurvey;

class ProfillingSurveyController
{
    public function index()
    {
        // Authorize user
        abort_if(authorize('view', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $survey = (new GetProfilingSurvey())->handle();

            return Inertia::render(config('route.profilling_survey.index'), [
                'survey' => $survey,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profilling_survey.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
