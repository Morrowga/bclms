<?php

namespace Src\BlendedConcept\Student\Domain\Policies;

class StudentPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_student');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_student');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_student');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_student');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_student');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_student');
    }
}
