<?php

namespace Src\BlendedConcept\Finance\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Roles\GetRoleWithPagniation;

class PlanController
{
    public function index()
    {

        $filters = request()->only(['page', 'search', 'perPage']);
        $plans = (new GetRoleWithPagniation($filters))->handle($filters);

        return Inertia::render(config('route.plans.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.plans.create'));
    }

    public function planfororg()
    {
        return Inertia::render(config('route.plans.planorg'));
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
