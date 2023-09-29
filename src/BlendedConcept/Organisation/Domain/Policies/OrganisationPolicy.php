<?php

namespace Src\BlendedConcept\Organisation\Application\Policies;

class OrganisationPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_organisation');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_organisation');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_organisation');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_organisation');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_organisation');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_organisation');
    }
}
