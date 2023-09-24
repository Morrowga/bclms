<?php

namespace Src\BlendedConcept\Survey\Domain\Policies;

class SurveyPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_survey');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_survey');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_survey');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_survey');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_survey');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_survey');
    }
}
