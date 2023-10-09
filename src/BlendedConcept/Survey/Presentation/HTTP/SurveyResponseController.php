<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Survey\Domain\Policies\SurveyResponsePolicy;
use Src\BlendedConcept\Survey\Application\Requests\StoreSurveyResponseRequest;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\StoreSurveyResponseCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResponses\GetSurveyResponses;
use Symfony\Component\HttpFoundation\Response;

class SurveyResponseController
{
    public function index()
    {
        // abort_if(authorize('view', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $filters = request()->only(['question', 'search', 'perPage', 'filter']);

            $surveyResponses = (new GetSurveyResponses($filters))->handle();

            return Inertia::render(config('route.surveyresponse.index'), [
                'surveyResponses' => $surveyResponses,
            ]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('surveyresponse.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show()
    {
        // abort_if(authorize('view', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.surveyresponse.show'));
    }

    public function view()
    {
        // abort_if(authorize('view', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.surveyresponse.view'));
    }

    public function store(StoreSurveyResponseRequest $request)
    {
        // return $request->all();
        try {
            $request->validated();
            // Creates a new StoreSurveyResponseCommand object and executes it.
            $storeSurveyResponseCommand = new StoreSurveyResponseCommand($request);
            $storeSurveyResponseCommand->execute();
        } catch (\Exception $e) {
            // Handle the exception here
            dd($e->getMessage());
        }
        /**
         * Returns a redirect response to the surveys index page.
         */
        return redirect()->route('dashboard');
    }
}
