<?php

namespace Src\BlendedConcept\Disability\Application\Policies;

class AccessibilityDevicePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_accessibility');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_accessibility');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_accessibility');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_accessibility');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_accessibility');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_accessibility');
    }
}
