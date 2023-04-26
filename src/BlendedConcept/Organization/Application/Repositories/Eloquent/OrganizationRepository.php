<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Resources\OrganizationResource;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getOrganizations($filters = [])
    {
        $paginate_organizations = OrganizationResource::collection(Organization::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_organizations = Organization::get();
        return [
            "paginate_organizations" => $paginate_organizations,
            "default_organizations" => $default_organizations
        ];
    }
}
