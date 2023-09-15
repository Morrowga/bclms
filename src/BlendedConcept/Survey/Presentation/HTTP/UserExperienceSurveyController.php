<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Survey\Application\Requests\StoreSurveyRequest;
use Src\BlendedConcept\Survey\Application\Requests\StoreQuestionRequest;

class UserExperienceSurveyController
{
    public function index()
    {

        return Inertia::render(config('route.userexperiencesurvey.index'));
    }

    public function create()
    {

        // return Inertia::render(config('route.userexperiencesurvey.create'));
        return Inertia::render(config('route.userexperiencesurvey.create'));
    }

    public function store(StoreSurveyRequest $request){
        return $request->all();
    }

    public function show()
    {
        return Inertia::render(config('route.userexperiencesurvey.show'));
    }

    public function edit()
    {
        // dd('hello');
        return Inertia::render(config('route.userexperiencesurvey.edit'));
    }
}
