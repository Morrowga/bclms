<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;

use Src\BlendedConcept\Organization\Application\UseCases\Queries\Student\GetLearningNeed;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Student\GetDisabilityTypes;
use Src\BlendedConcept\Organization\Application\Requests\StoreStudentRequest;
use Src\BlendedConcept\Organization\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Student\CreateStudentCommand;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Organization\Application\Requests\UpdateStudentRequest;
use Src\BlendedConcept\Organization\Application\DTO\StudentData;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Student\UpdateStudentCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\Student\GetStudentList;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\Student\DeleteStudentCommand;
class OrganizationStudentController
{

    public function index()
    {
        $filters = request(['search', 'first_name', 'last_name', 'email']) ?? [];
        $studentListWithPagniation = (new GetStudentList($filters))->handle();
        return Inertia::render(config('route.organizations-teacher.index'), [
            'students' => $studentListWithPagniation,
        ]);
    }
    public function create()
    {
        // $disability_types =
        $learningNeeds = (new GetLearningNeed())->handle();
        $disabilityTypes = (new GetDisabilityTypes())->handle();
        return Inertia::render(config('route.organizations-student.create'), compact('learningNeeds', 'disabilityTypes'));
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $newStudent = StudentMapper::fromRequest($request);
            $student = (new CreateStudentCommand($newStudent))->execute();

            return to_route('organizations-teacher.index')->with('successMessage', 'Student Created Successfully!');;
        } catch (\Exception $error) {
            dd($error->getMessage());
            return Inertia::render(config('route.organizations-student.create'));
        }
    }

    public function edit(StudentEloquentModel $organizations_student)
    {

        $organizations_student->load(['organizations', 'user', 'disability_types', 'learningneeds']);
        $learningNeeds = (new GetLearningNeed())->handle();
        $disabilityTypes = (new GetDisabilityTypes())->handle();

        return Inertia::render(
            config('route.organizations-student.edit'),
            compact('organizations_student', 'learningNeeds', 'disabilityTypes')
        );
    }

    public function update(StudentEloquentModel $organizations_student, UpdateStudentRequest $request)
    {

        try {

            $updateStudent = StudentData::fromRequest($request, $organizations_student);
            (new UpdateStudentCommand($updateStudent))->execute();

            return to_route('organizations-teacher.index')
                ->with('successMessage', 'Student Updated Successfully!');
        } catch (\Exception $error) {
            //throw $th;
        }
    }

    public function show(StudentEloquentModel $organizations_student)
    {

        $organizations_student->load(['organizations', 'user', 'disability_types', 'learningneeds']);

        // // return $organizations_student;
        return Inertia::render(config('route.organizations-student.show'),compact('organizations_student'));
    }

    public function destroy(StudentEloquentModel $organizations_student)
    {

        (new DeleteStudentCommand($organizations_student))->execute();

        return to_route('organizations-teacher.index')->with('successMessage', 'Student Deleted Successfully!');;
    }
}
