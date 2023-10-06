<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\System\Domain\Repositories\PageBuilderInterface;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetUserSurveyByRole;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetSuperAdminListCount;
use Src\BlendedConcept\Teacher\Application\UseCases\Queries\GetStudentsForOrgTeacherDashboard;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetUserForAdminDashBoard;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetStudentForAdminDashBoard;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetClassroomForOrgAdminDashboard;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetClassroomForOrgTeacherDashboard;

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
        $current_user_role = auth()->user()->role->name;
        $user = Auth::user();

        $user_survey = (new GetUserSurveyByRole('LOG_IN'))->handle();
        // return $userSurvey;
        $orgainzations_users = (new GetUserForAdminDashBoard())->handle();

        $students = (new GetStudentForAdminDashBoard())->handle();

        $UserCount = (new GetSuperAdminListCount())->handle();

        $classrooms = (new GetClassroomForOrgAdminDashboard($filters = request(['search', 'perPage', 'page'])))->handle()['paginate_classrooms'];
        $org_teacher_classrooms = (new GetClassroomForOrgTeacherDashboard($filters = []))->handle();
        $org_teacher_students = (new GetStudentsForOrgTeacherDashboard($filters = request(['search', 'perPage', 'page'])))->handle();

        //here I render it inside
        return Inertia::render(config('route.dashboard'), compact('current_user_role', 'user', 'orgainzations_users', 'students', 'UserCount', 'classrooms', 'org_teacher_classrooms', 'org_teacher_students', 'user_survey'));
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
