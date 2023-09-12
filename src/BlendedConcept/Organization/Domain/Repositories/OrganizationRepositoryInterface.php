<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Security\Domain\Model\User;

interface OrganizationRepositoryInterface
{
    public function getOrganizationNameId();

    public function getOrganizations($filers);

    public function createOrganization(Organization $organization, Subscription $subscription);

    public function updateOrganization(OrganizationData $organizationData);

    public function getOrganizationNameWithCount();
}
