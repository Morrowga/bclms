<?php

namespace Src\BlendedConcept\User\Domain\Policies;

use Src\BlendedConcept\User\Domain\Model\Permission;
use Src\BlendedConcept\User\Domain\Model\User;

class PermissionPolicy
{
    // check ur is authnicated or not
    // public $role = auth()->Permission()->roles->first();
    // public $permissons =  $role->permissions->pluck('name');
    public function view(User $user)
    {
        return $user->hasPermission('access_permission');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_permission');
    }
    public function store(User $user)
    {
        return $user->hasPermission('create_permission');
    }
    public function edit(User $user)
    {
        return $user->hasPermission('edit_permission');
    }

    public function update(User $user)
    {
        return $user->hasPermission('edit_permission');
    }

    public function destroy(User $user)
    {
        return $user->hasPermission('delete_permission');
    }
}
