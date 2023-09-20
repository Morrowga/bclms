<?php

namespace Src\BlendedConcept\Disability\Domain\Repositories;

use Src\BlendedConcept\Organization\Application\DTO\StudentData;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Student;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

interface StudentRepositoryInterface
{
    public function getStudents($filters);

    public function createStudent(Student $student);

    public function updateStudent(StudentData $studentData);

    public function deleteStudent(StudentEloquentModel $LearningNeed);
}
