<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans;

use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteOrganizationCommand implements CommandInterface
{
    private PlanRepositoryInterface $repository;

    public function __construct(
        private readonly PlanEloquentModel $plan
    ) {
        $this->repository = app()->make(PlanRepositoryInterface::class);
    }

    public function execute()
    {
        $this->plan->delete();
    }
}
