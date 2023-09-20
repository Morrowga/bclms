<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands\Teacher;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\TeacherRepositoryInterface;

class DeleteTeacherCommand implements CommandInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly int $teacher_id
    ) {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->delete($this->teacher_id);
    }
}
