<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\System\Domain\Repositories\PlanRepositoryInterface;

class PlanController
{
    private $planInterface;
    public function __construct(PlanRepositoryInterface $planInterface)
    {
        $this->planInterface = $planInterface;
    }

    public function index()
    {

        $plans = $this->planInterface->getPlans();
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Plans/Index');
    }
}
