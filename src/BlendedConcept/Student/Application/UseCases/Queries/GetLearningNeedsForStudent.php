<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;

class GetLearningNeedsForStudent implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getLearningNeedsForStudent();
    }
}
