<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;

class OrganizationTeacherStudentController
{
    public function index()
    {
        return Inertia::render(config('route.org_view_teacher_student.index'));
    }
}
