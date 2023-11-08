<?php

namespace Src\BlendedConcept\StoryBook\Domain\Policies;

class GamePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_game');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_game');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_game');
    }
    public static function store()
    {
        return auth()->user()->hasPermission('create_game');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_game');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_game');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_game');
    }
    public static function assign()
    {
        return auth()->user()->hasPermission('access_gameAssign');
    }
    public static function assign_show()
    {
        return auth()->user()->hasPermission('access_gameAssign');
    }
}
