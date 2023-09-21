<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries\Student;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\StudentRepositoryInterface;

class GetStudentList implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudents($this->filters);
    }
}
