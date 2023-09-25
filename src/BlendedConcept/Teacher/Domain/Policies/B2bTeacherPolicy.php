<?php

namespace Src\BlendedConcept\Teacher\Domain\Policies;

class B2bTeacherPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_b2bteacher');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_b2bteacher');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_b2bteacher');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_b2bteacher');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_b2bteacher');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_b2bteacher');
    }
}
