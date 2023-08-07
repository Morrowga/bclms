<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;


class PlanController
{


    public function index()
    {

        return Inertia::render(config('route.plans.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.plans.create'));
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function edit()
    {
        return Inertia::render(config('route.plan.edit'));
    }
}
