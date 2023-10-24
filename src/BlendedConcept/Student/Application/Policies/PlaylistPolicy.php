<?php

namespace Src\BlendedConcept\Student\Application\Policies;

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
    public static function show()
    {
        return auth()->user()->hasPermission('show_playlist');
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
