<?php

namespace Src\BlendedConcept\Disability\Application\Policies;

class LearningNeedPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_learningNeed');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_learningNeed');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_learningNeed');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_learningNeed');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_learningNeed');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_learningNeed');
    }
}
