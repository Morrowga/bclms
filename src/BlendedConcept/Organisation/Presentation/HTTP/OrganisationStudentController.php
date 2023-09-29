<?php

namespace Src\BlendedConcept\Organisation\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organisation\Application\DTO\StudentData;
use Src\BlendedConcept\Organisation\Application\Mappers\StudentMapper;
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
        $filters = request(['search', 'first_name', 'last_name', 'email']) ?? [];
        $studentListWithPagniation = (new GetStudentList($filters))->handle();

        return Inertia::render(config('route.organisations-teacher.index'), [
            'students' => $studentListWithPagniation,
        ]);
    }

    public function create()
    {
        // $disability_types =
        $learningNeeds = (new GetLearningNeed())->handle();
        $disabilityTypes = (new GetDisabilityTypes())->handle();

        return Inertia::render(config('route.organisations-student.create'), compact('learningNeeds', 'disabilityTypes'));
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $newStudent = StudentMapper::fromRequest($request);
            $student = (new CreateStudentCommand($newStudent))->execute();

            return to_route('organisations-teacher.index')->with('successMessage', 'Student Created Successfully!');
        } catch (\Exception $error) {
            dd($error->getMessage());

            return Inertia::render(config('route.organisations-student.create'));
        }
    }

    public function edit(StudentEloquentModel $organisations_student)
    {

        $organisations_student->load(['organisation', 'user', 'disability_types', 'learningneeds']);
        $learningNeeds = (new GetLearningNeed())->handle();
        $disabilityTypes = (new GetDisabilityTypes())->handle();

        return Inertia::render(
            config('route.organisations-student.edit'),
            compact('organisations_student', 'learningNeeds', 'disabilityTypes')
        );
    }

    public function update(StudentEloquentModel $organisations_student, UpdateStudentRequest $request)
    {

        try {

            $updateStudent = StudentData::fromRequest($request, $organisations_student);
            (new UpdateStudentCommand($updateStudent))->execute();

            return to_route('organisations-teacher.index')
                ->with('successMessage', 'Student Updated Successfully!');
        } catch (\Exception $error) {
            //throw $th;
        }
    }

    public function show(StudentEloquentModel $organisations_student)
    {

        $organisations_student->load(['organisation', 'user', 'disability_types', 'learningneeds']);

        // // return $organisations_student;
        return Inertia::render(config('route.organisations-student.show'), compact('organisations_student'));
    }

    public function destroy(StudentEloquentModel $organisations_student)
    {
        (new DeleteStudentCommand($organisations_student))->execute();

        return to_route('organisations-teacher.index')->with('successMessage', 'Student Deleted Successfully!');
    }
}
