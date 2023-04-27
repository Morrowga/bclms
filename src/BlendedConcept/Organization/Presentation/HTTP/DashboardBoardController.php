<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;

use function PHPUnit\Framework\returnValueMap;

class DashboardBoardController
{
    private $dashboardInertface;
    private $userRepositoryInterface;

    public function __construct(DashboardRepositoryInterface $dashboardInertface,UserRepositoryInterface $userRepositoryInterface)
    {
        $this->dashboardInertface = $dashboardInertface;
        $this->userRepositoryInterface = $userRepositoryInterface;
    }
    public function superAdminDashboard()
    {


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

        $orgainzations_users = $this->userRepositoryInterface->getUserForDashBoard();

        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Index', compact('current_user_role', 'user','orgainzations_users'));
    }


    public function userProfile()
    {
        return Inertia::render('Common/Layouts/Dashboard/UserProfile');
    }
}
