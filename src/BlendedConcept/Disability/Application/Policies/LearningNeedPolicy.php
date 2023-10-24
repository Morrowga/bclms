<?php

namespace Src\BlendedConcept\Disability\Application\Policies;

class LearningNeedPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_learning');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_learning');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_learning');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_learning');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_learning');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_learning');
    }
}
