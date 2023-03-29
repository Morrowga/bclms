<?php

namespace Src\BlendedConcept\User\Domain\Policies;

use Src\BlendedConcept\User\Domain\Model\User;

class RolePolicy
{
    // check ur is authnicated or not
    // public $role = auth()->Permission()->roles->first();
    // public $permissons =  $role->permissions->pluck('name');
    public function view(User $user)
    {
        return $user->hasPermission('access_role');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_role');
    }
    public function store(User $user)
    {
        return $user->hasPermission('create_role');
    }
    public function edit(User $user)
    {
        return $user->hasPermission('edit_role');
    }

    public function update(User $user)
    {
        return $user->hasPermission('edit_role');
    }

    public function destroy(User $user)
    {
        return $user->hasPermission('delete_role');
    }

}
