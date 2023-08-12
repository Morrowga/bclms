<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;

class AccessibilityDeviceController
{
    public function index()
    {

        return Inertia::render(config('route.accessibility_device.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.accessibility_device.create'));
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function edit()
    {
        // dd('hello');
        return Inertia::render(config('route.accessibility_device.edit'));
    }
}
