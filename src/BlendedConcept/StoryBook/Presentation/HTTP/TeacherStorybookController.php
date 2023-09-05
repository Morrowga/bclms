<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;

class TeacherStorybookController
{
    public function index()
    {
        return Inertia::render(config('route.teacher_storybook.index'));
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
