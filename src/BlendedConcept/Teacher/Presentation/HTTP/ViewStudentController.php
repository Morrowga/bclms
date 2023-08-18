<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;

class ViewStudentController
{
    public function index()
    {
        return Inertia::render(config('route.view_students.index'));
    }
    public function show()
    {
        return Inertia::render(config('route.view_students.show'));
    }

    public function create()
    {
        return Inertia::render(config('route.view_students.create'));
    }
    public function edit()
    {
        return Inertia::render(config('route.view_students.edit'));
    }
}
