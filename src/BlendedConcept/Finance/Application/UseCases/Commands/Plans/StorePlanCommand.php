<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans;

use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;
use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StorePlanCommand implements CommandInterface
{
    private PlanRepositoryInterface $repository;

    public function __construct(
        private readonly Plan $plan,
    ) {
        $this->repository = app()->make(PlanRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createPlan($this->plan);
    }
}
