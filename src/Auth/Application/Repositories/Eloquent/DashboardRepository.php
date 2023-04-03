<?php

namespace Src\Auth\Application\Repositories\Eloquent;

use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\User\Domain\Model\User;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getUsers()
    {
        $roles = auth()->user()->roles->first()->name;
        $user = '';
        if($roles == 'superadmin')
        {
            $user = User::with('roles')->orderBy('created_at','desc')->take(3)->get();
        }

        return $user;
    }
}
