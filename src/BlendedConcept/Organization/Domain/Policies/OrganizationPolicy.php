<?php

namespace Src\BlendedConcept\Organization\Domain\Policies;
use Src\BlendedConcept\Organization\Domain\Model\Organization;

class OrganizationPolicy
{
    public function view(Organization $organization)
    {

        return $organization->hasPermission('access_organization');
    }

    public function create(Organization $organization)
    {
        return $organization->hasPermission('create_organization');
    }
    public function store(Organization $organization)
    {
        return $organization->hasPermission('create_organization');
    }
    public function edit(Organization $organization)
    {
        return $organization->hasPermission('edit_organization');
    }

    public function update(Organization $organization)
    {
        return $organization->hasPermission('edit_organization');
    }

    public function destroy(Organization $organization)
    {
        return $organization->hasPermission('delete_organization');
    }
}
