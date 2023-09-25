<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Response;
use Src\BlendedConcept\Student\Domain\Policies\StudentPolicy;
use Src\BlendedConcept\Organization\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Application\UseCases\Queries\ShowStudent;
use Src\BlendedConcept\Organization\Application\Requests\UpdateStudentRequest;
use Src\BlendedConcept\Student\Application\UseCases\Queries\GetStudentWithPagination;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Student\UpdateStudentCommand;

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
        // return $student;
        return Inertia::render(config('route.teacher_students.show'), compact('student'));
    }

    public function create()
    {
        return Inertia::render(config('route.teacher_students.create'));
    }

    public function update(UpdateStudentRequest $request, StudentEloquentModel $teacher_student)
    {
        // abort_if(authorize('edit', StudentPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // try {
        $updateStudent = StudentData::fromRequest($request, $teacher_student);
        $updateStudent = (new UpdateStudentCommand($updateStudent));
        $updateStudent->execute();

        return redirect()->route('teacher_students.show', $teacher_student->student_id)->with('successMessage', 'Student Updated Successfully!');

        // } catch (\Exception $e) {

        //     return redirect()->route('teacher_students.show', $teacher_student->student_id)->with('sytemErrorMessage', $e->getMessage());
        // }
    }

    public function edit($id)
    {
        $student = (new ShowStudent($id))->handle();

        return Inertia::render(config('route.teacher_students.edit'), compact('student'));
    }
}
