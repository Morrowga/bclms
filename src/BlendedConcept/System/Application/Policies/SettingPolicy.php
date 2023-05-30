<?php

namespace Src\BlendedConcept\System\Application\Policies;

class SettingPolicy
{

    public static function view()
    {
        return auth()->user()->hasPermission('access_settings');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_user');
    }
    public static function store()
    {
        return auth()->user()->hasPermission('create_user');
    }
    public static function edit()
    {
        return auth()->user()->hasPermission('edit_user');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_user');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_user');
    }
}
