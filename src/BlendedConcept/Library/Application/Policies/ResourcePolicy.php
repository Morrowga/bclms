<?php

namespace Src\BlendedConcept\Library\Application\Policies;

class ResourcePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_resources');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_resources');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_resources');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_resources');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_resources');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_resources');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_resources');
    }
}
