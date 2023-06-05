<?php

namespace Src\BlendedConcept\Teacher\Domain\Repositories;

use Src\BlendedConcept\Teacher\Application\DTO\StudentData;
use Src\BlendedConcept\Teacher\Domain\Model\Student;

interface TeacherRepositoryInterface
{

    public function getStudent($filers);
    public function createStudent(Student $student);
    public function updateStudent(StudentData $studentData);
}
