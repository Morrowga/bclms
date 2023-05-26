<?php

namespace Src\BlendedConcept\System\Domain\Policies;


use Src\BlendedConcept\User\Domain\Model\User;

class AnnouncementPolicy
{

    public function view(User $user)
    {
        return $user->hasPermission('access_announcement');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_announcement');
    }
    public function store(User $user)
    {
        return $user->hasPermission('create_announcement');
    }
    public function edit(User $user)
    {
        return $user->hasPermission('edit_announcement');
    }

    public function update(User $user)
    {
        return $user->hasPermission('edit_announcement');
    }

    public function destroy(User $user)
    {
        return $user->hasPermission('delete_announcement');
    }
}
