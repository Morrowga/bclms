<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Resources\OrganizationResource;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getOrganizations()
    {
        // $organizations = OrganizationResource::collection(Organization::get());
    }
}
