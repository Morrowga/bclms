<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class AddCustomisationController
{
    public function index()
    {
        // return Inertia::render(config('route.add_customisation.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.add_customisation.create'));
    }

    public function edit()
    {
        return Inertia::render(config('route.add_customisation.edit'));
    }
}
