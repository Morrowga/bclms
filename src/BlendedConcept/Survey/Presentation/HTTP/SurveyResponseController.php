<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Survey\Application\Requests\StoreSurveyResponseRequest;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResults\GetSurveyResponses;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\StoreSurveyResponseCommand;

class SurveyResponseController
{
    public function index()
    {
        try {

            $filters = request()->only(['question', 'search', 'perPage', 'filter']);

            $surveyResults = (new GetSurveyResponses($filters))->handle();

            return Inertia::render(config('route.survey_results.index'), [
                'surveyResults' => $surveyResults,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('survey_results.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show()
    {
        return Inertia::render(config('route.survey_results.show'));
    }

    public function view()
    {
        return Inertia::render(config('route.survey_results.view'));
    }

    public function store(StoreSurveyResponseRequest $request){
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
