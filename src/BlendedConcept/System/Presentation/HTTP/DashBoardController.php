<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;


use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\System\Domain\Repositories\PageBuilderInterface;
use Src\Common\Infrastructure\Laravel\Controller;


class DashBoardController extends Controller
{
    private $securityRepositoryInterface;
    private $pageBuilderInterface;
    private $studentRepositoryInterface;

    public function __construct(
        SecurityRepositoryInterface $securityRepositoryInterface,
        PageBuilderInterface $pageBuilderInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
    ) {

        $this->securityRepositoryInterface = $securityRepositoryInterface;
        $this->pageBuilderInterface = $pageBuilderInterface;
        $this->studentRepositoryInterface = $studentRepositoryInterface;
    }

    public function superAdminDashboard()
    {


        /**
         *  Assigns the current user role based on
         *  the retrieved role from the authenticated user.
         */
        $current_user_role = auth()->user()->roles()->first()->name;
        $user = Auth::user();
        $orgainzations_users = $this->securityRepositoryInterface->getUserForDashBoard();

        $students = $this->studentRepositoryInterface->getStudent([])['default_students'];

        return Inertia::render(config('route.dashboard'), compact('current_user_role', 'user', 'orgainzations_users','students'));
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
}
