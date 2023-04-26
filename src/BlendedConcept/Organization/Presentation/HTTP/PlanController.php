<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\PlanRepositoryInterface;

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
