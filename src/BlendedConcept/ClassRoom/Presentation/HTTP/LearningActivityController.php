<?php

namespace Src\BlendedConcept\Classroom\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class LearningActivityController
{
    public function index(StoryBookEloquentModel $storybook)
    {
        return Inertia::render(config('route.learning_activities.index'), [
            "storybook" => $storybook
        ]);
    }
}
