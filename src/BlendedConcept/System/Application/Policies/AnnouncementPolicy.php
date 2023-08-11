<?php

namespace Src\BlendedConcept\System\Application\Policies;

class AnnouncementPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_announcement');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_announcement');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_announcement');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_announcement');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_announcement');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_announcement');
    }
}
