<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Inertia\Inertia;

class DisabilityDeviceController
{
    public function index()
    {

        return Inertia::render(config('route.disability_device.index'));
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
        return Inertia::render(config('route.plans.edit'));
    }
}
