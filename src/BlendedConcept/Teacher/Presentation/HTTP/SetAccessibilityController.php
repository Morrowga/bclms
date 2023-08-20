<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class SetAccessibilityController
{
    public function index()
    {
        return Inertia::render(config('route.set_accessibility_device.index'));
    }
}
