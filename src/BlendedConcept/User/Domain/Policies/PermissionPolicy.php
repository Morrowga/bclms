<?php

namespace Src\BlendedConcept\User\Domain\Policies;


class PermissionPolicy
{

    public function view()
    {
        return auth()->user()->hasPermission('access_permission');
    }

    public function create()
    {
        return auth()->user()->hasPermission('create_permission');
    }
    public function store()
    {
        return auth()->user()->hasPermission('create_permission');
    }
    public function edit()
    {
        return auth()->user()->hasPermission('edit_permission');
    }

    public function update()
    {
        return auth()->user()->hasPermission('edit_permission');
    }

    public function destroy()
    {
        return auth()->user()->hasPermission('delete_permission');
    }
}
