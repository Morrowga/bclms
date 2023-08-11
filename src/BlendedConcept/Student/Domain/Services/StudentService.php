<?php

namespace Src\BlendedConcept\Student\Domain\Services;

use Src\BlendedConcept\Student\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Application\Mappers\StudentMapper;
use Src\BlendedConcept\Student\Application\Requests\storeStudentRequest;
use Src\BlendedConcept\Student\Application\Requests\updateStudentRequest;
use Src\BlendedConcept\Student\Application\UseCases\Commands\StoreStudentCommand;
use Src\BlendedConcept\Student\Application\UseCases\Commands\UpdateStudentCommand;

class StudentService
{
    public function createStudent(storeStudentRequest $request)
    {
        $request->validated();
        $newUser = StudentMapper::fromRequest($request);

        $createNewUser = new StoreStudentCommand($newUser);
        $createNewUser->execute();
    }

    public function updateStudent(updateStudentRequest $request, $user_id)
    {
        $updateStudent = StudentData::fromRequest($request, $user_id);
        $updateStudent = (new UpdateStudentCommand($updateStudent));
        $updateStudent->execute();
    }

    public function deleteStudent($student)
    {
        $student->delete();
    }
}
