<?php

namespace Src\BlendedConcept\Disability\Application\Policies;

class ThemePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_theme');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_theme');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_theme');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_theme');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_theme');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_theme');
    }
}
