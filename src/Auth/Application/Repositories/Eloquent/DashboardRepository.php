<?php

namespace Src\Auth\Application\Repositories\Eloquent;

use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\User\Domain\Model\Student;
use Src\BlendedConcept\User\Domain\Model\User;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getUsers()
    {
        $roles = auth()->user()->roles->first()->name;

        if ($roles == 'BC Super Admin') {
            $users = User::with('roles')->orderBy('created_at', 'desc')->take(3)->get();
        } else if ($roles = 'BC Subscriber') {
            $users = Student::all();
        } else {
            $users = '';
        }

        return $users;
    }
}
