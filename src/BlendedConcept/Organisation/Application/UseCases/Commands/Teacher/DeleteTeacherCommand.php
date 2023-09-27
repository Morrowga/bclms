<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands\Teacher;

use Src\BlendedConcept\Organisation\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\CommandInterface;

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
