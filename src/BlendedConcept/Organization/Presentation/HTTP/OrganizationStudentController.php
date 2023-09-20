<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;

class OrganizationStudentController
{
    public function create()
    {
        return Inertia::render(config('route.organizations-student.create'));
    }

    public function store()
    {
        return Inertia::render(config('route.organizations-student.create'));
    }

    public function show()
    {
        return Inertia::render(config('route.organizations-student.show'));
    }

    public function edit()
    {
        return Inertia::render(config('route.organizations-student.edit'));
    }


}
