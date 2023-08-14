<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class GameController
{
    public function index()
    {

        return Inertia::render(config('route.games.index'));
    }
}
