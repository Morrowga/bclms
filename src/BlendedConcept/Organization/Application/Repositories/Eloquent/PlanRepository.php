<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Src\BlendedConcept\Organization\Domain\Repositories\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getPlans()
    {
        return 'datas';
    }
}
