<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class PlayListController
{
    public function index()
    {
        return Inertia::render(config('route.playlist.index'));
    }
}
