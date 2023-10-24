<?php

namespace Src\BlendedConcept\Finance\Application\Policies;


class SubscriptionPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_subscription');
    }

    public static function show()
    {
        return auth()->user()->hasPermission('show_subscription');
    }
    public static function create()
    {
        return auth()->user()->hasPermission('create_subscription');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_subscription');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_subscription');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_subscription');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_subscription');
    }
}
