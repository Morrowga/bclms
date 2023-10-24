<?php

namespace Src\BlendedConcept\StoryBook\Domain\Policies;

class PathwayPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_pathway');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_pathway');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_pathway');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_pathway');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_pathway');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_pathway');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_pathway');
    }
}
