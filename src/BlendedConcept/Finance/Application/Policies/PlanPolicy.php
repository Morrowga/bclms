<?php

namespace Src\BlendedConcept\Finance\Application\Policies;

class PlanPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_plan');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_plan');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_plan');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_plan');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_plan');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_plan');
    }
}
