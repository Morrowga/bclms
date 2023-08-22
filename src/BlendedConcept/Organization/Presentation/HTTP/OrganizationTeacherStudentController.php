<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;

class OrganizationTeacherStudentController
{
    public function index()
    {
        dd('hello');
        return Inertia::render(config('route.org_teacher_student.index'));
    }
}
