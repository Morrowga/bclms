<?php

namespace Src\BlendedConcept\ClassRoom\Application\Policies;


class ClassRoomPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_classroom');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_classroom');
    }
    public static function store()
    {
        return auth()->user()->hasPermission('create_classroom');
    }
    public static function edit()
    {
        return auth()->user()->hasPermission('edit_classroom');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_classroom');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_classroom');
    }
}
