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
    public function dashboard()
    {

        $users =  $this->dashboardInertface->getUsers();

        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Index',compact('users'));
    }
}
