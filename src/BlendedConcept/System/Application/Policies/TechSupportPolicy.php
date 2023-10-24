<?php

namespace Src\BlendedConcept\System\Application\Policies;

class TechSupportPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_techSupport');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_techSupport');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_techSupport');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_techSupport');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_techSupport');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_techSupport');
    }
}
