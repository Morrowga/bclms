<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

use Src\BlendedConcept\Organization\Application\DTO\TeacherData;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Teacher;

interface TeacherRepositoryInterface
{
    public function getTeachers($filters = []);

    public function showTeacher($id);

    public function CreateTeacher(Teacher $teacher);

    public function updateTeacher(TeacherData $teacherData);

    public function delete(int $teacher_id);
}
