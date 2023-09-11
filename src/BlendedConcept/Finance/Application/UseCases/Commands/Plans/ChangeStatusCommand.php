<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans;

use Src\BlendedConcept\Finance\Application\Requests\ChangeStatusPlanRequest;
use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\Common\Domain\CommandInterface;

class ChangeStatusCommand implements CommandInterface
{
    private PlanRepositoryInterface $repository;

    public function __construct(
        private readonly ChangeStatusPlanRequest $request,
        private readonly PlanEloquentModel $plan,
    ) {
        $this->repository = app()->make(PlanRepositoryInterface::class);
    }

    public function execute()
    {
        $this->repository->changeStatus($this->request, $this->plan);
    }
}
