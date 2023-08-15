<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;

class SurveyResultController
{
    public function index()
    {
        return Inertia::render(config('route.survey_results.index'));
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

    // public function edit()
    // {
    //     // dd('hello');
    //     return Inertia::render(config('route.suervey_results.edit'));
    // }
}
