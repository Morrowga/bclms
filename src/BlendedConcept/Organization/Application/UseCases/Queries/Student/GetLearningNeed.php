<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries\Student;

use Src\BlendedConcept\Organization\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetLearningNeed implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getLearningNeed();
    }
}
