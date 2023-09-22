<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResults\GetSurveyResults;

class SurveyResultController
{
    public function index()
    {
        try {

            $filters = request()->only(['question', 'search', 'perPage']);

            $surveyResults = (new GetSurveyResults($filters))->handle();

            return Inertia::render(config('route.survey_results.index'), [
                'surveyResults' => $surveyResults,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('survey_results.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    // public function create()
    // {
    //     // return Inertia::render(config('route.suervey_results.create'));
    //     return Inertia::render(config('route.suervey_results.edit'));
    // }

    public function show()
    {
        return Inertia::render(config('route.survey_results.show'));
    }

    public function view()
    {
        return Inertia::render(config('route.survey_results.view'));
    }

    // public function edit()
    // {
    //     // dd('hello');
    //     return Inertia::render(config('route.suervey_results.edit'));
    // }
}
