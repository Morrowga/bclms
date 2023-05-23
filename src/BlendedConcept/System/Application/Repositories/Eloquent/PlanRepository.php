<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Domain\Repositories\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getPlans()
    {
        return 'datas';
    }
}
