<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries\Teacher;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\TeacherRepositoryInterface;

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
