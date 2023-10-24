<?php

namespace Src\BlendedConcept\Disability\Application\Policies;

class DisabilityTypePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_disability');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_disability');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_disability');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_disability');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_disability');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_disability');
    }
}
