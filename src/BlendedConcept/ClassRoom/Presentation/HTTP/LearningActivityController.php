<?php

namespace Src\BlendedConcept\ClassRoom\Presentation\HTTP;

use Devleaptech\LaravelH5p\Eloquents\H5pContent;
use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookAssignmentEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

class LearningActivityController
{
    public function index(StoryBookEloquentModel $storybook, StudentEloquentModel $student)
    {
        $filters = request(['search', 'name']) ?? [];
        $storybook_version_ids = StoryBookAssignmentEloquentModel::where('student_id', $student->student_id)->pluck('storybook_version_id');
        $verionIds = $storybook->storybook_versions->whereIn('id', $storybook_version_ids)->pluck('h5p_id'); // get h5p_id from storybook version

        $h5pContents = H5pContent::with('eloquent_user')->whereIn('id', $verionIds)->paginate($filters['perPage'] ?? 10); // get all h5p content realated with storybook versions
        // dd($h5pContents);
        return Inertia::render(config('route.learning_activities.index'), [
            'storybook' => $storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions']),
            'h5p_contents' => $h5pContents,
            'student' => $student
        ]);
    }
}
