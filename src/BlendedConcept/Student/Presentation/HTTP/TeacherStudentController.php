<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;

use Src\BlendedConcept\Organisation\Application\Requests\UpdateStudentRequest;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Student\UpdateStudentCommand;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Student\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Student\Application\Requests\storeStudentRequest;
use Src\BlendedConcept\Student\Application\UseCases\Commands\StoreStudentCommand;
use Src\BlendedConcept\Student\Application\UseCases\Commands\StoreTeacherStudentCommand;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetDisabilityTypesForStudent;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetLearningNeedsForStudent;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetStudentWithPagination;
use Src\BlendedConcept\Student\Application\UseCases\Queries\ShowStudent;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Student\Domain\Policies\StudentPolicy;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Application\UseCases\Commands\UpdateTeacherStudentCommand;

class TeacherStudentController
{
    public function index()
    {
        try {

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'search', 'perPage', 'filter']) ?? [];

            // Retrieve users with pagination using the provided filters
            $students = (new GetStudentWithPagination($filters))->handle()['paginate_students'];

            // return $students;
            return Inertia::render(config('route.teacher_students.index'), compact('students'));
            // return Inertia::render(config('route.students'), compact('students'));
        } catch (\Exception $e) {
            return redirect()->route('teacher_students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show($id)
    {
        $student = (new ShowStudent($id))->handle();
        return Inertia::render(config('route.teacher_students.show'), compact('student'));
    }
    public function store(storeStudentRequest $request)
    {

        // abort_if(authorize('create', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($request->all());
        try {

            $request->validated();
            $newUser = StudentMapper::fromRequest($request);

            $createNewUser = new StoreTeacherStudentCommand($newUser);
            $createNewUser->execute();

            return redirect()->route('teacher_students.index')->with('successMessage', 'Student created successfully!');
        } catch (\Exception $e) {
            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('teacher_students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {
        $disabilityTypes = (new GetDisabilityTypesForStudent())->handle();
        $learningNeeds = (new GetLearningNeedsForStudent())->handle();
        return Inertia::render(config('route.teacher_students.create'), [
            'disabilityTypes' => $disabilityTypes,
            'learningNeeds' => $learningNeeds
        ]);
    }

    public function update(UpdateStudentRequest $request, StudentEloquentModel $teacher_student)
    {
        // abort_if(authorize('edit', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($request->all());
        try {
            $updateStudent = StudentData::fromRequest($request, $teacher_student->student_id);
            $updateStudent = (new UpdateTeacherStudentCommand($updateStudent));
            $updateStudent->execute();

            return redirect()->route('teacher_students.show', $teacher_student->student_id)->with('successMessage', 'Student Updated Successfully!');
        } catch (\Exception $e) {

            return redirect()->route('teacher_students.show', $teacher_student->student_id)->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $student = (new ShowStudent($id))->handle();

        $disabilityTypes = (new GetDisabilityTypesForStudent())->handle();
        $learningNeeds = (new GetLearningNeedsForStudent())->handle();
        return Inertia::render(config('route.teacher_students.edit'), [
            'student' => $student,
            'disabilityTypes' => $disabilityTypes,
            'learningNeeds' => $learningNeeds
        ]);
    }

    public function kidMode(UserEloquentModel $user)
    {
        Auth::logout();
        Auth::login($user);

        return redirect()->route('dashboard'); // Redirect to the kid's home page.
    }
}
