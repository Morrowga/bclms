<?php

namespace Src\BlendedConcept\Organization\Domain\Policies;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\User\Domain\Model\User;

class OrganizationPolicy
{
    public function view(User $user)
    {
        return $user->hasPermission('access_organization');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_organization');
    }
    public function store(User $user)
    {
        return $user->hasPermission('create_organization');
    }
    public function edit(User $user)
    {
        return $user->hasPermission('edit_organization');
    }

    public function update(User $user)
    {
        return $user->hasPermission('edit_organization');
    }

    public function destroy(User $user)
    {
        return $user->hasPermission('delete_organization');
    }
}
