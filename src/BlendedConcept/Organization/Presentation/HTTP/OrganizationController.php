<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;

class OrganizationController
{
    private $organizationInterface;
    public function __construct(OrganizationRepositoryInterface $organizationInterface)
    {
        $this->organizationInterface = $organizationInterface;
    }

    public function index()
    {
        $organizations = $this->organizationInterface->getOrganizations();
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Organizations/Index');
    }
}
