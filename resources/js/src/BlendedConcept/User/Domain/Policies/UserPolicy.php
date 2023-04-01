<?php

namespace Src\BlendedConcept\User\Domain\Policies;

use Src\BlendedConcept\User\Domain\Model\User;

class UserPolicy
{


    // check ur is authnicated or not
    // public $role = auth()->user()->roles->first();
    // public $permissons =  $role->permissions->pluck('name');

    public function view(User $user)
    {
        return $user->hasPermission('access_user');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_user');
    }
    public function store(User $user)
    {
        return $user->hasPermission('create_user');
    }
    public function edit(User $user)
    {
        return $user->hasPermission('edit_user');
    }

    public function update(User $user)
    {
        return $user->hasPermission('edit_user');
    }

    public function destroy(User $user)
    {
        return $user->hasPermission('delete_user');
    }
}
