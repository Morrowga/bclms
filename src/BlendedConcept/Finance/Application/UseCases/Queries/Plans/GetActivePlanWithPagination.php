<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Queries\Plans;

use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetActivePlanWithPagination implements QueryInterface
{
    private PlanRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(PlanRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getActivePlans($this->filters);
    }
}
