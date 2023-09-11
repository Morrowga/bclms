<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\Organization\Domain\Model\Organization;

interface OrganizationRepositoryInterface
{
    public function getOrganizationNameId();

    public function getOrganizations($filers);

    public function createOrganization(Organization $organization);

    public function updateOrganization(OrganizationData $organizationData);

    public function getOrganizationNameWithCount();
}
