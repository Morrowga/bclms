<?php

namespace Src\BlendedConcept\User\Domain\Policies;
class SettingPolicy
{

    public function view()
    {
        return auth()->user()->hasPermission('access_settings');
    }

    public function create()
    {
        return auth()->user()->hasPermission('create_user');
    }
    public function store()
    {
        return auth()->user()->hasPermission('create_user');
    }
    public function edit()
    {
        return auth()->user()->hasPermission('edit_user');
    }

    public function update()
    {
        return auth()->user()->hasPermission('edit_user');
    }

    public function destroy()
    {
        return auth()->user()->hasPermission('delete_user');
    }
}
