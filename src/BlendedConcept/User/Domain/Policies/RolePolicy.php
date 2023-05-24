<?php

namespace Src\BlendedConcept\User\Domain\Policies;



class RolePolicy
{

    public function view()
    {
        return auth()->user()->hasPermission('access_role');
    }

    public function create()
    {
        return auth()->user()->hasPermission('create_role');
    }
    public function store()
    {
        return auth()->user()->hasPermission('create_role');
    }
    public function edit()
    {
        return auth()->user()->hasPermission('edit_role');
    }

    public function update()
    {
        return auth()->user()->hasPermission('edit_role');
    }

    public function destroy()
    {
        return auth()->user()->hasPermission('delete_role');
    }

}
