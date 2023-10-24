<?php

namespace Src\BlendedConcept\Survey\Domain\Policies;

class ProfillingSurveyPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_profilling');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_profilling');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_profilling');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_profilling');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_profilling');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_profilling');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_profilling');
    }
}
