<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;

class PlayListController
{
    public function index()
    {
        return Inertia::render(config('route.playlist.index'));
    }

    public function create()
    {
        return Inertia::render(config('route.playlist.create'));
    }

    public function edit()
    {
        return Inertia::render(config('route.playlist.edit'));
    }

    public function show()
    {
        return Inertia::render(config('route.playlist.show'));
    }
}
