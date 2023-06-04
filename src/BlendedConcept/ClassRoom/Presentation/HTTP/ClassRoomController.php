<?php

namespace Src\BlendedConcept\ClassRoom\Presentation\HTTP;

use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomEloquentModel;
use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Src\BlendedConcept\ClassRoom\Application\Policies\ClassRoomPolicy;
use Src\BlendedConcept\ClassRoom\Application\Requests\storeClassRoomRequest;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Queries\GetClassRoomWithPagination;
use Src\BlendedConcept\ClassRoom\Domain\Services\ClassRoomService;
use Src\BlendedConcept\Student\Application\Requests\storeStudentRequest;
use Src\BlendedConcept\Student\Application\Requests\updateStudentRequest;
use Src\BlendedConcept\Student\Domain\Policies\StudentPolicy;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetStudentWithPagination;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Symfony\Component\HttpFoundation\Response;

class ClassRoomController extends Controller
{

    protected $classRoomService;

    public function __construct()
    {
        $this->classRoomService = app()->make(ClassRoomService::class);
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

        abort_if(authorize('view', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
    /**
     * Store a new user.
     *
     * @param storeClassRoomRequest $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(storeClassRoomRequest $request)
    {
        abort_if(authorize('create', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $this->classRoomService->createClassRoom($request);

            return redirect()->route('classrooms.index')->with("successMessage", "ClassRoom created successfully!");
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('students.index')->with("sytemErrorMessage", $e->getMessage());
        }
    }



    //update Classroom
    public function update(updateStudentRequest $request, ClassRoomEloquentModel $classroom)
    {
        abort_if(authorize('edit', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->classRoomService->updateClassRoom($request, $classroom->id);
        return redirect()->route('students.index')->with("successMessage", "ClassRoom Updated Successfully!");
    }


    public function destroy(ClassRoomEloquentModel $classroom)
    {
        abort_if(authorize('destroy', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->classRoomService->deleteClassRoom($classroom);
        return redirect()->route('students.index')->with("successMessage", "Student Deleted Successfully!");
    }
}
