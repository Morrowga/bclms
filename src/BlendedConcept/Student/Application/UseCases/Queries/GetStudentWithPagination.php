<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries;

use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudentWithPagination implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudent($this->filters);
    }
}
