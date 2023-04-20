<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;

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
        if ($user_role == 'superadmin') {
            $current_user_role = $user_role;
        } elseif ($user_role == 'staff') {
            $current_user_role = $user_role;
        } else {
            $current_user_role = $user_role;
        }
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Index', [
            'current_user_role' => $current_user_role
        ]);
    }
}
