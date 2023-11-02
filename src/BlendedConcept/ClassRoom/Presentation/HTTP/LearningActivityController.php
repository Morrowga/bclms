<?php

namespace Src\BlendedConcept\ClassRoom\Presentation\HTTP;

use Devleaptech\LaravelH5p\Eloquents\H5pContent;
use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

class LearningActivityController
{
    public function index(StoryBookEloquentModel $storybook, StudentEloquentModel $student)
    {
        // $verionIds = $storybook->storybook_versions->pluck('h5p_id'); // get h5p_id from storybook version
        $teacher_ids = $student->teachers()->pluck('teachers.teacher_id');
        $parent_ids = $student->parent()->pluck('parent_id');
        $verionIds = StoryBookVersionEloquentModel::where('storybook_id', $storybook->id)->whereIn('teacher_id', $teacher_ids)->orWhereIn('parent_id', $parent_ids)->pluck('h5p_id');

        $h5pContents = H5pContent::with('eloquent_user')->whereIn('id', $verionIds)->get(); // get all h5p content realated with storybook versions

        return Inertia::render(config('route.learning_activities.index'), [
            'storybook' => $storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions']),
            'h5p_contents' => $h5pContents,
            'student' => $student
        ]);
    }
}
