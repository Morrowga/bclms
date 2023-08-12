<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class RewardController
{
    public function index()
    {

        return Inertia::render(config('route.reward.index'));
    }

    public function create()
    {
        // return Inertia::render(config('route.userexperiencesurvey.create'));
        return Inertia::render(config('route.userexperiencesurvey.edit'));
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
