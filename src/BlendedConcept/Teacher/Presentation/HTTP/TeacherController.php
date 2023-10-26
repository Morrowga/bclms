<?php

namespace Src\BlendedConcept\Teacher\Presentation\HTTP;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Security\Application\Requests\StoreUserRequest;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUserName;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Application\Requests\UpdateTeacherRequest;
use Src\BlendedConcept\Teacher\Application\Requests\UpdateTeacherStorage;
use Src\BlendedConcept\Teacher\Application\UseCases\Queries\GetTeachersWithPagination;
use Src\BlendedConcept\Teacher\Domain\Policies\TeacherPolicy;
use Src\BlendedConcept\Teacher\Domain\Services\TeacherService;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\Common\Application\Imports\StudentImport;
use Src\Common\Application\Imports\UserImport;
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

        // abort_if(authorize('view', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            return redirect()->back()->with('errorMessage', $e->getMessage());
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
        // abort_if(authorize('create', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            $this->teacherService->createTeacher($request);

            return redirect()->route('c.teachers.index')->with('successMessage', 'User created successfully!');
        } catch (\Exception $e) {

            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    //update user
    public function update(UpdateTeacherRequest $request, UserEloquentModel $teacher)
    {
        // abort_if(authorize('edit', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $this->teacherService->updateTeacher($request, $teacher->id);

            return redirect()->route('c.teachers.index')->with('successMessage', 'User Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function destroy(UserEloquentModel $user)
    {
        // abort_if(authorize('destroy', TeacherPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $this->teacherService->deleteTeacher($user);

            return redirect()->route('c.teachers.index')->with('successMessage', 'User Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
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
        $organisation_id = auth()->user()->organisation_id;
        $organisation = OrganisationEloquentModel::find($organisation_id);
        $orgusedStorage = MediaEloquentModel::where('collection_name', 'videos')
            ->where('organisation_id', $organisation_id)
            ->where('teacher_id', null)
            ->where('status', 'active')
            ->sum('size');

        $teacherUsedStorage = MediaEloquentModel::where('collection_name', 'videos')
            ->where('organisation_id', $organisation_id)
            ->whereNotNull('teacher_id')
            ->where('status', 'active')
            ->sum('size');
        $organisation = $organisation->load('teachers.user', 'subscription.b2b_subscription');
        $org_used_storage = $orgusedStorage == 0 ? $orgusedStorage : (int)($orgusedStorage / 1024 / 1024);
        $teacher_used_storage = $teacherUsedStorage == 0 ? $teacherUsedStorage : (int)($teacherUsedStorage / 1024 / 1024);

        $data = $organisation->teachers;
        $array_data = $data->map(function ($teacher) use ($organisation_id) {
            $usedStorage = MediaEloquentModel::where(function ($query) use ($organisation_id, $teacher) {
                $query->where('collection_name', 'videos')
                    ->where('organisation_id', $organisation_id)
                    ->where('teacher_id', $teacher->user->id)
                    ->whereIn('status', ['active', 'requested']);
            })
                ->sum('size');
            $used_storage_mb = $usedStorage == 0 ? $usedStorage : (int)($usedStorage / 1024 / 1024);
            $left_storage = $teacher->allocated_storage_limit - $used_storage_mb;
            return [
                "teacher_id" => $teacher->teacher_id,
                "used_storage" => $used_storage_mb,
                "allocated_storage_limit" => $teacher->allocated_storage_limit,
                "user" => $teacher->user,
                "organisation_id" => $teacher->organisation_id,
                "left_storage" => $left_storage
            ];
        });
        return Inertia::render(config('route.listofteacher.index'), [
            'organisation' => $organisation,
            'org_used_storage' => $org_used_storage,
            'teacher_used_storage' => $teacher_used_storage,
            'teachers' => $array_data
        ]);
    }

    public function listofteacherUpdateStorage(TeacherEloquentModel $teacher, UpdateTeacherStorage $request)
    {
        try {

            $this->teacherService->updateTeacherStorage($teacher, $request);

            return redirect()->route('listoforgteacher')->with('successMessage', 'Teacher storage updated successfully!');
        } catch (\Exception $e) {

            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function import_excel(Request $request)
    {
        if ($request->hasFile('file')) {
            if ($request->type == 'teacher') {
                $import = new UserImport($request);
            } else {
                $import = new StudentImport($request);
            }
            $import->import($request->file('file'));
            if ($import->failures()->count() > 0) {
                $errorRows = [];
                $currentRow = null;
                foreach ($import->failures() as $failure) {
                    $currentRow = $failure->row();
                    if ($currentRow == $failure->row()) {
                        if (!in_array($failure->values(), $errorRows)) {
                            array_push($errorRows, $failure->values());
                        }
                    }
                }

                return redirect()->back()->with('export_errors', $errorRows)->with('successMessage', 'Import Successfully!');
            }

            return back();
        } else {
            return redirect()->back()->with('systemError', 'You need to import excel file');
        }
    }
}
