<?php

namespace Src\BlendedConcept\Student\Application\Policies;

class TeacherStudentPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_teacherStudent');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_teacherStudent');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_teacherStudent');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_teacherStudent');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_teacherStudent');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_teacherStudent');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_teacherStudent');
    }
}
