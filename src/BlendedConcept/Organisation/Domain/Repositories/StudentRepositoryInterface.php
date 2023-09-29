<?php

namespace Src\BlendedConcept\Organisation\Domain\Repositories;

use Src\BlendedConcept\Organisation\Application\DTO\StudentData;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\Student;

interface StudentRepositoryInterface
{
    public function getStudents($filters);

    public function createStudent(Student $student);

    public function updateStudent(StudentData $studentData);

    public function deleteStudent($student);

    public function getLearningNeed();

    public function getdisabilitytype();
}
