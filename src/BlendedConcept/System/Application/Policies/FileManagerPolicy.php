<?php

namespace Src\BlendedConcept\System\Application\Policies;

class FileManagerPolicy
{

    public static function view()
    {
        return auth()->user()->hasPermission('access_library');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('access_library');
    }
    public static function store()
    {
        return auth()->user()->hasPermission('access_library');
    }
    public static function edit()
    {
        return auth()->user()->hasPermission('access_library');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('access_library');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('access_library');
    }
}
