<?php

namespace Src\BlendedConcept\Survey\Domain\Policies;

class SurveyResponsePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_surveyresponses');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_surveyresponses');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_surveyresponses');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_surveyresponses');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_surveyresponses');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_surveyresponses');
    }
}
