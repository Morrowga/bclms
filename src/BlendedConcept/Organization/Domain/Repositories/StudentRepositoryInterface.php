<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

use Src\BlendedConcept\Organization\Application\DTO\StudentData;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Student;

interface StudentRepositoryInterface
{
    public function getStudents($filters);

    public function createStudent(Student $student);

    public function updateStudent(StudentData $studentData);

    public function deleteStudent($student);

    public function getLearningNeed();

    public function getdisabilitytype();
}
