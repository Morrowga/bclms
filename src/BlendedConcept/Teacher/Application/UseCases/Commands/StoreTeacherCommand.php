<?php

namespace Src\BlendedConcept\Teacher\Application\UseCases\Commands;


use Src\BlendedConcept\Teacher\Domain\Model\Teacher;
use Src\BlendedConcept\Teacher\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\CommandInterface;


class StoreTeacherCommand implements CommandInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly Teacher $teacher
    )
    {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->CreateTeacher($this->teacher);
    }
}
