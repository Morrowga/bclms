<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Src\Auth\Domain\Repositories\DashboardRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\PageBuilderInterface;


class DashBoardController
{
    private $userRepositoryInterface;
    private $pageBuilderInterface;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface,
        PageBuilderInterface $pageBuilderInterface,
    ){

        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->pageBuilderInterface = $pageBuilderInterface;
    }

    public function superAdminDashboard()
    {
        /**
         *  Assigns the current user role based on
         *  the retrieved role from the authenticated user.
         */
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

        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/index', compact('current_user_role', 'user', 'orgainzations_users'));
    }


    public function userProfile()
    {
        dd("hello");
        return Inertia::render('Common/Layouts/Dashboard/UserProfile');
    }


    /***
     * this below funcitons are all related to with
     * laravel pagebuilder package where we separate each
     * function where we can asset each assets and methods
     * using controller from routes
     */
    public function getAssertUrl()
    {
        $this->pageBuilderInterface->generalAssetUrl();
    }

    public function websiteManagerUrl()
    {
        $this->pageBuilderInterface->useWebsiteManager();
    }

    public function UseRouter()
    {
        $this->pageBuilderInterface->useRouter();
    }


    public function UploadsUrl()
    {
        $this->pageBuilderInterface->uploadsUrl();
    }
}
