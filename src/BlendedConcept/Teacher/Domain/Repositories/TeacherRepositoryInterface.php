<?php

namespace Src\BlendedConcept\Teacher\Domain\Repositories;

use Src\BlendedConcept\Teacher\Application\DTO\TeacherData;
use Src\BlendedConcept\Teacher\Domain\Model\Teacher;

interface TeacherRepositoryInterface
{
    public function getTeachers($filters = []);

    public function CreateTeacher(Teacher $teacher);

    public function updateTeacher(TeacherData $teacherData);

    public function getOrgTeacherStudents($filters);
}
