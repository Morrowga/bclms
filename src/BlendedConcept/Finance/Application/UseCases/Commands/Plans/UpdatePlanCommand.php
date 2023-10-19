<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans;

use Src\BlendedConcept\Finance\Application\DTO\PlanData;
use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdatePlanCommand implements CommandInterface
{
    private PlanRepositoryInterface $repository;

    public function __construct(
        private readonly PlanData $planData,
    ) {
        $this->repository = app()->make(PlanRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updatePlan($this->planData);
    }
}
