<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Inertia\Inertia;

class SetAccessibilityController
{
    public function index()
    {
        return Inertia::render(config('route.set_accessibility_device.index'));
    }
}
