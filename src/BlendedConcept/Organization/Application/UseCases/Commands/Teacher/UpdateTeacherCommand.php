<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher;

use Src\BlendedConcept\Organization\Application\DTO\TeacherData;
use Src\BlendedConcept\Organization\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateTeacherCommand implements CommandInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly TeacherData $teacher
    ) {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateTeacher($this->teacher);
    }
}