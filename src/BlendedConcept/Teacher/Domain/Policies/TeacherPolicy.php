<?php

namespace Src\BlendedConcept\Teacher\Domain\Policies;


class TeacherPolicy
{

    public  static function view()
    {
        return auth()->user()->hasPermission('access_teacher');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_teacher');
    }
    public static function store()
    {
        return auth()->user()->hasPermission('create_teacher');
    }
    public static function edit()
    {
        return auth()->user()->hasPermission('edit_teacher');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_teacher');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_teacher');
    }
}
