<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student;

use Src\BlendedConcept\Organisation\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

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
