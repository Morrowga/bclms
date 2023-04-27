<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\Organization\Domain\Requests\UpdateOrganizationRequest;

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
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Organizations/Index', [
            'organizations' => $organizations['paginate_organizations']
        ]);
    }

    public function store(StoreOrganizationRequest $request)
    {
        $request->validated();
        $this->organizationInterface->createOrganization($request);
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Created Successfully!");
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $this->organizationInterface->updateOrganization($request, $organization);

        return redirect()->route('organizations.index')->with("successMessage", "Organization Updated Successfully!");
    }
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Deleted Successfully!");
    }
}
