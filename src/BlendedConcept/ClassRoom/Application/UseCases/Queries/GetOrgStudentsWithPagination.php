<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Queries;

use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrgStudentsWithPagination implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudentsByOrgTeacher($this->filters);
    }
}
