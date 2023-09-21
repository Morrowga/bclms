<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries\Teacher;

use Src\BlendedConcept\Organization\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetTeacherList implements QueryInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getTeachers();
    }
}
