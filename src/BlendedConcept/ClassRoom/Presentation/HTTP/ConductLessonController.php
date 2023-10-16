<?php

namespace Src\BlendedConcept\Classroom\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

class ConductLessonController
{
    public function index()
    {
        return Inertia::render(config('route.conduct_lessons.index'));
    }

    public function show(Request $request)
    {
        $version_id = $request->query('storybook_id');
        $version = StoryBookVersionEloquentModel::findOrFail($version_id);
        // $storybook_id = $request->
        return Inertia::render(config('route.conduct_lessons.show'), [
            "version" => $version
        ]);
    }
}
