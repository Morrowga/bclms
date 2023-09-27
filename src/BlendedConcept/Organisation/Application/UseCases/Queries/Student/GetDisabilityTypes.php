<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student;

use Src\BlendedConcept\Organisation\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetDisabilityTypes implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getdisabilitytype();
    }
}
