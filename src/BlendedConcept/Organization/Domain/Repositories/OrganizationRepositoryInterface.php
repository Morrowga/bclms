<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

use Src\BlendedConcept\Organization\Domain\Model\Organization;

interface OrganizationRepositoryInterface
{
    public function getOrganizationNameId();
    public function getOrganizations($filers);
    public function createOrganization($request);
    public function updateOrganization($request, $organization);
}
