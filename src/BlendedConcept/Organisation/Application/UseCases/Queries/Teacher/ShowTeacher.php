<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Queries\Teacher;

use Src\BlendedConcept\Organisation\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class ShowTeacher implements QueryInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly int $id
    ) {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->showTeacher($this->id);
    }
}
