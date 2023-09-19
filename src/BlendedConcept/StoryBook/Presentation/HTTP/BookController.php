<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetDevice;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetDisabilityType;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetLearningNeed;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetTheme;

class BookController
{
    public function index()
    {
        $learningneeds = (new GetLearningNeed())->handle();

        $themes = (new GetTheme())->handle();

        $disability_types = (new GetDisabilityType())->handle();

        $devices = (new GetDevice())->handle();

        return Inertia::render(config('route.books.index'),compact('learningneeds','themes','disability_types','devices'));
    }

    public function store()
    {

    }
}
