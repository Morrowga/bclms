<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Src\BlendedConcept\Student\Application\Requests\storeStudentRequest;
use Src\BlendedConcept\Student\Application\Requests\updateStudentRequest;
use Src\BlendedConcept\Student\Domain\Policies\StudentPolicy;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetStudentWithPagination;
use Src\BlendedConcept\Student\Domain\Services\StudentService;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    protected $studentService;

    protected $route_url;

    public function __construct()
    {
        $this->studentService = app()->make(StudentService::class);
    }

    /***
     *  @params null
     *
     *  @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     *
     */
    public function index()
    {


        /****
         *  this will change route url
         *   `c.` if tenanct exist and default `` if not exits
         ****/
        $this->route_url = tenant() ? "c." : "";



        // Check if the user is authorized to view users

        abort_if(authorize('view', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage']) ?? [];

            // Retrieve users with pagination using the provided filters
            $students = (new GetStudentWithPagination($filters))->handle()['paginate_students'];

            return Inertia::render(config('route.students'), compact('students'));
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
    /**
     * Store a new user.
     *
     * @param storeStudentRequest $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(storeStudentRequest $request)
    {

        abort_if(authorize('create', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $this->studentService->createStudent($request);

            return redirect()->route($this->route_url . 'students.index')->with("successMessage", "Student created successfully!");
        } catch (\Exception $e) {
            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route($this->route_url . 'students.index')->with("sytemErrorMessage", $e->getMessage());
        }
    }



    //update user
    public function update(updateStudentRequest $request, StudentEloquentModel $student)
    {
        abort_if(authorize('edit', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $this->studentService->updateStudent($request, $student->id);
            return redirect()->route($this->route_url . 'students.index')->with("successMessage", "Student Updated Successfully!");

        } catch (\Exception $e) {

            return redirect()->route($this->route_url . 'students.index')->with("sytemErrorMessage", $e->getMessage());
        }
    }


    public function destroy(StudentEloquentModel $student)
    {
        abort_if(authorize('destroy', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->studentService->deleteStudent($student);
        return redirect()->route($this->route_url . 'students.index')->with("successMessage", "Student Deleted Successfully!");
    }
}
