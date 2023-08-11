<?php

namespace Src\BlendedConcept\Security\Presentation\HTTP;

use Inertia\Inertia;

class UserExperienceSurveyController
{
    public function index()
    {

        return Inertia::render(config('route.userexperiencesurvey.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.userexperiencesurvey.create'));
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function edit()
    {
        // dd('hello');
        return Inertia::render(config('route.plans.edit'));
    }
}
