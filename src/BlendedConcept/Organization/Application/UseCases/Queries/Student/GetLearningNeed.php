<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries\Student;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\StudentRepositoryInterface;

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
