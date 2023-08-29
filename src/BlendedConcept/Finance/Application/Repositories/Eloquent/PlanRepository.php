<?php

namespace Src\BlendedConcept\Finance\Application\Repositories\Eloquent;

use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getPlans()
    {
        return 'datas';
    }
}
