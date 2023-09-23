<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;


use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetGameList;
class TeacherStorybookController
{
    public function index()
    {

        $filters = request()->only(['search', 'name', 'perPage']) ?? [];
        $storyBooks = (new GetStoryBook($filters))->handle();
        return Inertia::render(config('route.teacher_storybook.index'),compact('storyBooks'));
    }

    public function edit()
    {
        return Inertia::render(config('route.teacher_storybook.edit'));
    }

    public function show(StoryBookEloquentModel $teacher_storybook)
    {
        $teacher_storybook->load(['devices','learningneeds','themes','disability_types','storybook_versions']);

        $games = (new GetGameList())->handle();


        $storybooks = (new GetStoryBook($filters = []))->handle();

        return Inertia::render(config('route.teacher_storybook.show'),compact('teacher_storybook','games','storybooks'));
    }

    public function assign_student(StoryBookEloquentModel $teacher_storybook,StoryBookVersionEloquentModel $version)
    {
        $filters = request(['search', 'first_name', 'last_name']) ?? [];
        $students = (new GetStudentList($filters))->handle();
        $teacher_storybook->load(['learningneeds','themes','disability_types','devices']);

        return Inertia::render(config('route.teacher_storybook.assign_student'),compact('teacher_storybook','version','students'));
    }
}
