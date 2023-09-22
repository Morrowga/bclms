<?php

namespace Src\BlendedConcept\Student\Domain\Repositories;

use Src\BlendedConcept\Student\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Domain\Model\Student;

interface StudentRepositoryInterface
{
    public function getStudent($filers);

    public function createStudent(Student $student);

    public function updateStudent(StudentData $studentData);

    public function getStudentsByPagination($filers);

    public function getStudentsByOrgTeacher($filers);
}
