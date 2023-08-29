<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\Requests\StoreUserRequest;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUserName;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Application\Requests\UpdateTeacherRequest;
use Src\BlendedConcept\Teacher\Application\UseCases\Queries\GetTeachersWithPagination;
use Src\BlendedConcept\Teacher\Domain\Policies\TeacherPolicy;
use Src\BlendedConcept\Teacher\Domain\Services\TeacherService;
use Src\Common\Infrastructure\Laravel\Controller;
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

        abort_if(authorize('view', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'email', 'role', 'search', 'perPage', 'roles']) ?? [];

            // Retrieve users with pagination using the provided filters with teacher roles
            $users = (new GetTeachersWithPagination($filters))->handle();

            // return $users;

            // Retrieve user names
            $users_name = (new GetUserName())->handle();
            // Render the Inertia view with the obtained data
            return Inertia::render(config('route.teachers'), [
                'users' => $users,
                'users_name' => $users_name,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('c.teachers.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Store a new user.
     *
     * @param  StoreUserRequest  $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        abort_if(authorize('create', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            $this->teacherService->createTeacher($request);

            return redirect()->route('c.teachers.index')->with('successMessage', 'User created successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('c.teachers.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    //update user
    public function update(UpdateTeacherRequest $request, UserEloquentModel $teacher)
    {
        abort_if(authorize('edit', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->teacherService->updateTeacher($request, $teacher->id);

        return redirect()->route('c.teachers.index')->with('successMessage', 'User Updated Successfully!');
    }

    public function destroy(UserEloquentModel $user)
    {
        abort_if(authorize('destroy', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->teacherService->deleteTeacher($user);

        return redirect()->route('c.teachers.index')->with('successMessage', 'User Deleted Successfully!');
    }

    public function viewteacher()
    {
        return Inertia::render(config('route.viewteacher.viewteacher'));
    }

    public function editteacher()
    {
        return Inertia::render(config('route.viewteacher.editteacher'));
    }
    public function listofteacher()
    {
        return Inertia::render(config('route.listofteacher.index'));
    }
}
