<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUserName;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Roles\GetRoleName;

use Src\BlendedConcept\Security\Application\Requests\StoreUserRequest;
use Src\BlendedConcept\Security\Application\Requests\UpdateUserRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUsersWithPagination;

use Src\BlendedConcept\Security\Application\Policies\UserPolicy;
use Src\BlendedConcept\Teacher\Domain\Services\TeacherService;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends Controller
{

    protected $teacherService;

    public function __construct()
    {
        $this->teacherService = app()->make(TeacherService::class);
    }

    /***
     *  @params null
     *
     *  @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     *
     */
    public function index()
    {

        // Check if the user is authorized to view users

        abort_if(authorize('view', UserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'email', 'role', 'search', 'perPage', 'roles']) ?? [];

            // Retrieve users with pagination using the provided filters with teacher roles
            $users = (new GetUsersWithPagination($filters))->handle()[1];

            // Retrieve user names
            $users_name = (new GetUserName())->handle();


            // Retrieve role names
            $roles_name = (new GetRoleName())->handle();
            // Render the Inertia view with the obtained data
            return Inertia::render(config('route.users'), [
                'users' => $users,
                'users_name' => $users_name,
                'roles_name' => $roles_name
            ]);
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
    /**
     * Store a new user.
     *
     * @param StoreUserRequest $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        abort_if(authorize('create', UserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            $this->teacherService->createUser($request);

            return redirect()->route('users.index')->with("successMessage", "User created successfully!");
        } catch (\Exception $e) {
            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('users.index')->with("sytemErrorMessage", $e->getMessage());
        }
    }



    //update user
    public function update(UpdateUserRequest $request, UserEloquentModel $user)
    {
        abort_if(authorize('edit', UserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->teacherService->updateUser($request, $user->id);
        return redirect()->route('users.index')->with("successMessage", "User Updated Successfully!");
    }


    public function destroy(UserEloquentModel $user)
    {
        abort_if(authorize('destroy', UserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->teacherService->deleteUser($user);
        return redirect()->route('users.index')->with("successMessage", "User Deleted Successfully!");
    }

}
