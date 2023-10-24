<?php

namespace Src\BlendedConcept\Organisation\Application\Policies;

class OrganisationUserPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_organisationUser');
    }

    public static function show()
    {
        return auth()->user()->hasPermission('show_organisationUser');
    }
    public static function create()
    {
        return auth()->user()->hasPermission('create_organisationUser');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_organisationUser');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_organisationUser');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_organisationUser');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_organisationUser');
    }
}
