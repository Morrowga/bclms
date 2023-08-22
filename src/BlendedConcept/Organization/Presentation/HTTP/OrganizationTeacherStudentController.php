<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;

class OrganizationTeacherStudentController
{
    public function index()
    {
        return Inertia::render(config('route.org_view_teacher_student.index'));
    }
    public function showTeacher()
    {
        return Inertia::render(config('route.org_view_teacher_student.teacher-show'));
    }
    public function editTeacher()
    {
        return Inertia::render(config('route.org_view_teacher_student.teacher-edit'));
    }
    public function createTeacher()
    {
        return Inertia::render(config('route.org_view_teacher_student.teacher-create'));
    }

    public function showStudent()
    {
        return Inertia::render(config('route.org_view_teacher_student.student-show'));
    }
    public function editStudent()
    {
        return Inertia::render(config('route.org_view_teacher_student.student-edit'));
    }
    public function createStudent()
    {
        return Inertia::render(config('route.org_view_teacher_student.student-create'));
    }
}
