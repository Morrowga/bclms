<?php

namespace Src\BlendedConcept\Finance\Domain\Repositories;

use Src\BlendedConcept\FInance\Application\DTO\PlanData;
use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;

interface PlanRepositoryInterface
{
    public function getPlans($filters);
    public function getActivePlans($filters);
    public function getInactivePlans($filters);
    public function createPlan(Plan $plan);
    public function updatePlan(PlanData $planData);
    public function changeStatus($request, $plan);
}
