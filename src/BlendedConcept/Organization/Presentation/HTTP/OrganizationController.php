<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\Organization\Domain\Requests\UpdateOrganizationRequest;
use Src\Common\Infrastructure\Laravel\Controller;

class OrganizationController extends Controller
{
    private $organizationInterface;
    public function __construct(OrganizationRepositoryInterface $organizationInterface)
    {
        $this->organizationInterface = $organizationInterface;
    }

    public function index()
    {

        $this->authorize('view', Organization::class);
        $organizations = $this->organizationInterface->getOrganizations();
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Organizations/Index', [
            'organizations' => $organizations['paginate_organizations']
        ]);
    }

    public function store(StoreOrganizationRequest $request)
    {
        $this->authorize('create', Organization::class);
        $request->validated();
        $this->organizationInterface->createOrganization($request);
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Created Successfully!");
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $this->authorize('edit', Organization::class);
        $this->organizationInterface->updateOrganization($request, $organization);

        return redirect()->route('organizations.index')->with("successMessage", "Organization Updated Successfully!");
    }
    public function destroy(Organization $organization)
    {
        $this->authorize('destroy', Organization::class);
        $organization->delete();
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Deleted Successfully!");
    }
}
