<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\StoryBook\Domain\Policies\TeacherBookPolicy;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;

class TeacherStorybookController
{
    public function index()
    {
        abort_if(authorize('view', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $filters = request()->only(['search', 'name', 'perPage', 'filter']) ?? [];
        $storyBooks = (new GetStoryBook($filters))->handle();

        return Inertia::render(config('route.teacher_storybook.index'), compact('storyBooks'));
    }

    public function edit()
    {
        abort_if(authorize('edit', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render(config('route.teacher_storybook.edit'));
    }

    public function show(StoryBookEloquentModel $teacher_storybook)
    {
        abort_if(authorize('show', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $teacher_id = auth()->user()->b2bUser->teacher_id;
        $filters = request(['search', 'filter', 'perPage', 'page']);
        $teacher_storybook->load(['devices', 'learningneeds', 'themes', 'disability_types', 'storybook_versions' => function ($query) use ($teacher_id) {
            $query->where('teacher_id', $teacher_id);
        }]);
        $games = (new GetGameList($filters))->handle();

        $storybooks = (new GetStoryBook($filters = []))->handle();

        return Inertia::render(config('route.teacher_storybook.show'), compact('teacher_storybook', 'games', 'storybooks'));
    }

    public function assign_student(StoryBookEloquentModel $teacher_storybook, StoryBookVersionEloquentModel $version)
    {
        abort_if(authorize('assign', TeacherBookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $filters = request(['search', 'first_name', 'last_name']) ?? [];
        $students = (new GetStudentList($filters))->handle();
        $teacher_storybook->load(['learningneeds', 'themes', 'disability_types', 'devices']);
        $version = $version->load('storybook_assigments');
        // dd($students);
        return Inertia::render(config('route.teacher_storybook.assign_student'), compact('teacher_storybook', 'version', 'students'));
    }
}
