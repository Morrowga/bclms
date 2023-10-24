<?php

namespace Src\BlendedConcept\System\Application\Policies;

class SiteThemePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_siteTheme');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_siteTheme');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_siteTheme');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_siteTheme');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_siteTheme');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_siteTheme');
    }
}
