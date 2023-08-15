<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class AssignRewardController
{
    public function index()
    {

        return Inertia::render(config('route.assign_rewards.index'));
    }

    public function create()
    {
        // return Inertia::render(config('route.userexperiencesurvey.create'));
        return Inertia::render(config('route.assign_rewards.create'));
    }

    public function show()
    {
        return Inertia::render(config('route.userexperiencesurvey.show'));
    }

    public function edit()
    {
        // dd('hello');
        return Inertia::render(config('route.assign_rewards.edit'));
    }
}
