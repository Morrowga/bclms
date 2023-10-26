<?php

namespace Src\BlendedConcept\Organisation\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Application\DTO\StudentData;
use Src\BlendedConcept\Organisation\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Organisation\Application\Policies\OrganisationUserPolicy;
use Src\BlendedConcept\Organisation\Application\Requests\StoreStudentRequest;
use Src\BlendedConcept\Organisation\Application\Requests\UpdateStudentRequest;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Student\CreateStudentCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Student\DeleteStudentCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\Student\UpdateStudentCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetDisabilityTypes;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetLearningNeed;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;

class OrganisationStudentController
{
    public function index()
    {
        abort_if(authorize('view', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $filters = request(['search', 'first_name', 'last_name', 'email']) ?? [];
        $studentListWithPagniation = (new GetStudentList($filters))->handle();

        return Inertia::render(config('route.organisations-teacher.index'), [
            'students' => $studentListWithPagniation,
        ]);
    }

    public function create()
    {
        // $disability_types =
        abort_if(authorize('create', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $learningNeeds = (new GetLearningNeed())->handle();
        $disabilityTypes = (new GetDisabilityTypes())->handle();

        return Inertia::render(config('route.organisations-student.create'), compact('learningNeeds', 'disabilityTypes'));
    }

    public function store(StoreStudentRequest $request)
    {
        abort_if(authorize('store', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $newStudent = StudentMapper::fromRequest($request);
            $student = (new CreateStudentCommand($newStudent))->execute();

            return to_route('organisations-teacher.index')->with('successMessage', 'Student Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function edit(StudentEloquentModel $organisations_student)
    {
        abort_if(authorize('edit', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $organisations_student->load(['organisation', 'user', 'disability_types', 'learningneeds', 'parent']);
        $learningNeeds = (new GetLearningNeed())->handle();
        $disability_types = (new GetDisabilityTypes())->handle();

        return Inertia::render(
            config('route.organisations-student.edit'),
            compact('organisations_student', 'learningNeeds', 'disability_types')
        );
    }

    public function update(StudentEloquentModel $organisations_student, UpdateStudentRequest $request)
    {

        abort_if(authorize('update', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $updateStudent = StudentData::fromRequest($request, $organisations_student);
            (new UpdateStudentCommand($updateStudent))->execute();

            return to_route('organisations-teacher.index')
                ->with('successMessage', 'Student Updated Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function show(StudentEloquentModel $organisations_student)
    {
        abort_if(authorize('show', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $organisations_student->load(['organisation', 'user', 'disability_types', 'learningneeds', 'parent']);

        // // return $organisations_student;
        return Inertia::render(config('route.organisations-student.show'), compact('organisations_student'));
    }

    public function destroy(StudentEloquentModel $organisations_student)
    {
        abort_if(authorize('destroy', OrganisationUserPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            (new DeleteStudentCommand($organisations_student))->execute();

            return to_route('organisations-teacher.index')->with('successMessage', 'Student Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }
}
