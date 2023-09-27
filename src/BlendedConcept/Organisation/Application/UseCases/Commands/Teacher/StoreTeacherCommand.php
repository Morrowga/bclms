<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands\Teacher;

use Src\BlendedConcept\Organisation\Domain\Model\Entities\Teacher;
use Src\BlendedConcept\Organisation\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreTeacherCommand implements CommandInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly Teacher $teacher
    ) {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->CreateTeacher($this->teacher);
    }
}
