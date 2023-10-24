<?php

namespace Src\BlendedConcept\System\Application\Policies;

class SettingPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_setting');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_setting');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_setting');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_setting');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_setting');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_setting');
    }
}
