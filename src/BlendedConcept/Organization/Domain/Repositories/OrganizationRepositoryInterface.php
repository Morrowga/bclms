<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

interface OrganizationRepositoryInterface
{
    public function getOrganizations();
    public function createOrganization($request);
    public function updateOrganization($request, $organization);
}
