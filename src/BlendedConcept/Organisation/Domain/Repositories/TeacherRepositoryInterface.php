<?php

namespace Src\BlendedConcept\Organisation\Domain\Repositories;

use Src\BlendedConcept\Organisation\Application\DTO\TeacherData;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\Teacher;

interface TeacherRepositoryInterface
{
    public function getTeachers($filters);

    public function showTeacher($id);

    public function CreateTeacher(Teacher $teacher);

    public function updateTeacher(TeacherData $teacherData);

    public function delete(int $teacher_id);
}
