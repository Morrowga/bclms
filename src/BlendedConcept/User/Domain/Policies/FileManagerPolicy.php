<?php

namespace Src\BlendedConcept\User\Domain\Policies;

use Src\BlendedConcept\User\Domain\Model\User;

class FileManagerPolicy
{

    public function view(User $user)
    {
        return $user->hasPermission('access_library');
    }

    public function create(User $user)
    {
        return $user->hasPermission('access_library');
    }
    public function store(User $user)
    {
        return $user->hasPermission('access_library');
    }
    public function edit(User $user)
    {
        return $user->hasPermission('access_library');
    }

    public function update(User $user)
    {
        return $user->hasPermission('access_library');
    }

    public function destroy(User $user)
    {
        return $user->hasPermission('access_library');
    }
}
