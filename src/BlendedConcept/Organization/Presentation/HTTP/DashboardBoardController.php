<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;


class DashboardBoardController
{
    private $dashboardInertface;

    public function __construct(DashboardRepositoryInterface $dashboardInertface)
    {
        $this->dashboardInertface = $dashboardInertface;
    }
    public function superAdminDashboard()
    {
        // $users =  $this->dashboardInertface->getUsers();

        $user_role = auth()->user()->roles()->first()->name;
        $current_user_role = "";
        if ($user_role == 'BC Super Admin') {
            $current_user_role = $user_role;
        } elseif ($user_role == 'BC Staff') {
            $current_user_role = $user_role;
        } else {
            $current_user_role = $user_role;
        }

        $user = Auth::user();



        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Index', compact('current_user_role', 'user'));
    }


    public function userProfile()
    {
        return Inertia::render('Common/Layouts/Dashboard/UserProfile');
    }
}
