<?php

namespace Src\BlendedConcept\Student\Domain\Policies;

class PlaylistPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_playlist');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_playlist');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_playlist');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_playlist');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_playlist');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_playlist');
    }
}
