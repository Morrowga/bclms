<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetStudentForAdminDashBoard;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetUserForAdminDashBoard;
use Src\BlendedConcept\System\Domain\Repositories\PageBuilderInterface;
use Src\Common\Infrastructure\Laravel\Controller;

class DashBoardController extends Controller
{
    private $pageBuilderInterface;

    private $ClassRoomRepositoryInterface;

    public function __construct(
        PageBuilderInterface $pageBuilderInterface,
        ClassRoomRepositoryInterface $ClassRoomRepositoryInterface
    ) {
        $this->pageBuilderInterface = $pageBuilderInterface;
        $this->ClassRoomRepositoryInterface = $ClassRoomRepositoryInterface;
    }

    public function superAdminDashboard()
    {
        /**
         *  Assigns the current user role based on
         *  the retrieved role from the authenticated user.
         */
        $current_user_role = auth()->user()->roles()->first()->name;
        $user = Auth::user();

        $orgainzations_users = (new GetUserForAdminDashBoard())->handle();

        $students = (new GetStudentForAdminDashBoard())->handle();

        //here I render it inside
        return Inertia::render(config('route.dashboard'), compact('current_user_role', 'user', 'orgainzations_users', 'students'));
    }

    /***
     * this below funcitons are all related to with
     * laravel pagebuilder package where we separate each
     * function where we can asset each assets and methods
     * using controller from routes
     */

    /**
     * Get the asset URL from the page builder.
     *
     * @return string|null
     */
    public function getAssertUrl()
    {
        return $this->pageBuilderInterface->generalAssetUrl();
    }

    /**
     * Use the website manager in the page builder.
     *
     * @return void
     */
    public function websiteManagerUrl()
    {
        $this->pageBuilderInterface->useWebsiteManager();
    }

    /**
     * Use the router in the page builder.
     *
     * @return void
     */
    public function UseRouter()
    {
        $this->pageBuilderInterface->useRouter();
    }

    /**
     * Get the uploads URL from the page builder.
     *
     * @return string|null
     */
    public function UploadsUrl()
    {
        return $this->pageBuilderInterface->uploadsUrl();
    }

    public function orgTeacherProfile()
    {

        return Inertia::render(config('route.profiles.org-teacher'));
    }
    public function editOrgTeacherProfile()
    {

        return Inertia::render(config('route.edit-profiles.org-teacher'));
    }
}
