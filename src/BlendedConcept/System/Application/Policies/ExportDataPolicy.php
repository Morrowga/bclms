<?php

namespace Src\BlendedConcept\System\Application\Policies;

class ExportDataPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_exportData');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_exportData');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_exportData');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_exportData');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_exportData');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_exportData');
    }
}
