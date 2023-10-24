<?php

namespace Src\BlendedConcept\StoryBook\Domain\Policies;

class RewardPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_reward');
    }

    public static function create()
    {
        return auth()->user()->hasPermission('create_reward');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_reward');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_reward');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_reward');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_reward');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_reward');
    }
}
