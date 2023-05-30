<?php

namespace Src\BlendedConcept\System\Application\Policies;


class OrganizationPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_organization');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_organization');
    }
    public static function store()
    {
        return auth()->user()->hasPermission('create_organization');
    }
    public static function edit()
    {
        return auth()->user()->hasPermission('edit_organization');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_organization');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_organization');
    }
}
