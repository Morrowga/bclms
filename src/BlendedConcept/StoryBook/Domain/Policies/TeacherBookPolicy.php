<?php

namespace Src\BlendedConcept\StoryBook\Domain\Policies;

class TeacherBookPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_teacherBook');
    }
    public static function assign()
    {
        return auth()->user()->hasPermission('access_assignStudent');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_teacherBook');
    }
    public static function create()
    {
        return auth()->user()->hasPermission('create_teacherBook');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_teacherBook');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_teacherBook');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_teacherBook');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_teacherBook');
    }
}
