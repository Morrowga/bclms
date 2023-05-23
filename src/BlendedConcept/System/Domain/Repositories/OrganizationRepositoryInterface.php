<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

interface OrganizationRepositoryInterface
{
    public function getOrganizationNameId();
    public function getOrganizations($filers);
    public function createOrganization($request);
    public function updateOrganization($request, $organization);
}
