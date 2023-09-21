<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;


use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
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

    public function show()
    {
        return Inertia::render(config('route.teacher_storybook.show'));
    }

    public function assign_student()
    {
        return Inertia::render(config('route.teacher_storybook.assign_student'));
    }
}
