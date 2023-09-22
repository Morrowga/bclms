<?php

namespace Src\BlendedConcept\ClassRoom\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomGroupData;
use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomGroupMapper;
use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomMapper;
use Src\BlendedConcept\ClassRoom\Application\Requests\storeClassRoomRequest;
use Src\BlendedConcept\ClassRoom\Application\Requests\StoreGroupRequest;
use Src\BlendedConcept\ClassRoom\Application\Requests\updateClassRoomRequest;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Commands\StoreClassRoomCommand;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Commands\StoreClassroomGroupCommand;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Commands\UpdateClassRoomCommand;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Commands\UpdateClassroomGroupCommand;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Queries\GetClassRoomWithPagination;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Queries\GetOrgStudentsWithPagination;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Queries\GetStudentsWithPagination;
use Src\BlendedConcept\ClassRoom\Domain\Policies\ClassRoomPolicy;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomEloquentModel;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassroomGroupEloquentModel;
use Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser\GetClassroomForOrgTeacherDashboard;
use Src\Common\Infrastructure\Laravel\Controller;
use Symfony\Component\HttpFoundation\Response;

class ClassRoomController extends Controller
{
    /***
     *  @params null
     *
     *  @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     *
     */
    public function index()
    {

        // Check if the user is authorized to view classrooms

        // abort_if(authorize('view', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $classrooms = (new GetClassRoomWithPagination($filters))->handle()['paginate_classrooms'];

            return Inertia::render(config('route.classrooms'), compact('classrooms'));
        } catch (\Exception $e) {

            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function showCopy(ClassRoomEloquentModel $classroom)
    {
        try {
            // dd($classroom->load('students', 'teachers')->loadCount('students', 'teachers'));
            return Inertia::render(config('route.showCopy'), [
                'classroom' => $classroom->load(['students' => function ($query) {
                    $query->doesntHave('groups');
                }, 'teachers', 'groups'])->loadCount('students', 'teachers'),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function editCopy(ClassRoomEloquentModel $classroom)
    {
        try {
            return Inertia::render(config('route.editCopy'), [
                'classroom' => $classroom->load('students', 'teachers')->loadCount('students', 'teachers'),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return Inertia::render(config('route.createCopy'));
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Store a new user.
     *
     * @param  storeClassRoomRequest  $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(storeClassRoomRequest $request)
    {

        abort_if(authorize('create', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $request->validated();
            $newUser = ClassRoomMapper::fromRequest($request);

            $createNewUser = new StoreClassRoomCommand($newUser);
            $createNewUser->execute();

            return redirect()->route('classrooms.index')->with('successMessage', 'ClassRoom created successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());

            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    //update Classroom
    public function update(updateClassRoomRequest $request, ClassRoomEloquentModel $classroom)
    {
        abort_if(authorize('edit', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $updateClassRoom = ClassRoomData::fromRequest($request, $classroom->id);
            $updateClassRoom = (new UpdateClassRoomCommand($updateClassRoom));
            return redirect()->route('classrooms.index')->with('successMessage', 'ClassRoom Updated Successfully!');
            $updateClassRoom->execute();
        } catch (\Exception $e) {
            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function destroy(ClassRoomEloquentModel $classroom)
    {
        abort_if(authorize('destroy', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classroom->delete();

        return redirect()->route('classrooms.index')->with('successMessage', 'Student Deleted Successfully!');
    }

    public function orgTeacherIndex()
    {
        try {
            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $classrooms = (new GetClassroomForOrgTeacherDashboard($filters))->handle();

            return Inertia::render(config('route.org-teacher-classroom.index'), compact('classrooms'));
        } catch (\Exception $e) {

            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function orgTeacherShow(ClassRoomEloquentModel $classroom)
    {
        try {
            return Inertia::render(config('route.org-teacher-classroom.show'), [
                'classroom' => $classroom->load(['students' => function ($query) {
                    $query->doesntHave('groups');
                }, 'teachers', 'groups'])->loadCount('students', 'teachers'),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function orgTeacherEdit()
    {
        return Inertia::render(config('route.org-teacher-classroom.edit'));
    }

    public function orgTeacherCreate()
    {
        return Inertia::render(config('route.org-teacher-classroom.create'));
    }

    public function orgTeacherAddGroup(ClassRoomEloquentModel $classroom)
    {

        try {
            $filters = request(['search', 'page', 'perPage']);
            $students = (new GetOrgStudentsWithPagination($filters))->handle();
            return Inertia::render(config('route.org-teacher-classroom.add-group'), [
                'classroom' => $classroom,
                'students' => $students
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function orgTeacherStoreGroup(StoreGroupRequest $request)
    {
        try {
            $request->validated();
            $newUser = ClassRoomGroupMapper::fromRequest($request);

            $createNewGroup = new StoreClassroomGroupCommand($newUser);
            $createNewGroup->execute();

            return redirect()->route('org-teacher-classroom.show', $request->classroom_id)->with('successMessage', 'Classroom Group created successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());

            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('org-teacher-classroom.show', $request->classroom_id)->with('sytemErrorMessage', $e->getMessage());
        }
    }
    public function orgTeacherUpdateGroup(StoreGroupRequest $request, ClassroomGroupEloquentModel $classroomGroup)
    {
        try {
            $updateClassRoomGroup = ClassRoomGroupData::fromRequest($request, $classroomGroup->id);
            $updateClassRoomGroup = (new UpdateClassroomGroupCommand($updateClassRoomGroup));
            return redirect()->route('org-teacher-classroom.show', $classroomGroup->classroom_id)->with('successMessage', 'Classroom Group Updated Successfully!');
            $updateClassRoomGroup->execute();
        } catch (\Exception $e) {
            return redirect()->route('org-teacher-classroom.show', $classroomGroup->classroom_id)->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function orgTeacherEditGroup(ClassroomGroupEloquentModel $classroomGroup)
    {

        $filters = request(['search', 'page', 'perPage']);
        $students = (new GetOrgStudentsWithPagination($filters))->handle();
        return Inertia::render(config('route.org-teacher-classroom.edit-group'), [
            'classroom_group' => $classroomGroup->load('students'),
            'students' => $students
        ]);
    }


    public function orgTeacherDeleteGroup(ClassroomGroupEloquentModel $classroomGroup)
    {
        try {
            //code...
            $classroomGroup->delete();
            return redirect()->route('org-teacher-classroom.show', $classroomGroup->classroom_id)->with('successMessage', 'Classroom Group Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->route('org-teacher-classroom.show', $classroomGroup->classroom_id)->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
