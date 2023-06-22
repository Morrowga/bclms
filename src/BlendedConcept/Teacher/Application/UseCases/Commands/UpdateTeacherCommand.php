<?php

namespace Src\BlendedConcept\Teacher\Application\UseCases\Commands;


use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Teacher\Application\DTO\TeacherData;
use Src\BlendedConcept\Teacher\Domain\Repositories\TeacherRepositoryInterface;

class UpdateTeacherCommand implements CommandInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly TeacherData $teacherData
    )
    {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateTeacher($this->teacherData);
    }
}