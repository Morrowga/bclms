<?php

namespace Src\BlendedConcept\ClassRoom\Presentation\HTTP;

use Devleaptech\LaravelH5p\Eloquents\H5pContent;
use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class LearningActivityController
{
    public function index(StoryBookEloquentModel $storybook)
    {
        $verionIds = $storybook->storybook_versions->pluck('h5p_id'); // get h5p_id from storybook version
        $h5pContents = H5pContent::with('eloquent_user')->whereIn('id', $verionIds)->get(); // get all h5p content realated with storybook versions

        return Inertia::render(config('route.learning_activities.index'), [
            "storybook" => $storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions']),
            'h5p_contents' => $h5pContents
        ]);
    }
}
