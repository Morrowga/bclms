<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

use Src\BlendedConcept\Organization\Application\DTO\StudentData;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Student;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\StudentEloquentModel;

interface StudentRepositoryInterface
{
    public function getStudents($filters);

    public function createStudent(Student $student);

    public function updateStudent(StudentData $studentData);

    public function deleteStudent(StudentEloquentModel $studentEloquentModel);

    public function getLearningNeed();

    public function getdisabilitytype();
}
