<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\Organization\Domain\Requests\UpdateOrganizationRequest;
use Illuminate\Http\Request;
use Src\Common\Infrastructure\Laravel\Controller;

class OrganizationController extends Controller
{
    private $organizationInterface;
    public function __construct(OrganizationRepositoryInterface $organizationInterface)
    {
        $this->organizationInterface = $organizationInterface;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Organization::class);
        $filters = request()->only(['page','search', 'perPage']);
        $organizations = $this->organizationInterface->getOrganizations($filters);
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Organizations/Index', [
            'organizations' => $organizations['paginate_organizations']
        ]);
    }

    public function create()
    {
        abort(404);
    }



    public function store(StoreOrganizationRequest $request)
    {
        $this->authorize('create', Organization::class);
        $request->validated();
        $this->organizationInterface->createOrganization($request);
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Created Successfully!");
    }

    public function edit()
    {
        abort(404);
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $this->authorize('edit', Organization::class);
        $this->organizationInterface->updateOrganization($request, $organization);

        return redirect()->route('organizations.index')->with("successMessage", "Organization Updated Successfully!");
    }

    public function show()
    {
        abort(404);
    }

    public function destroy(Organization $organization)
    {
        $this->authorize('destroy', Organization::class);
        $organization->delete();
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Deleted Successfully!");
    }
}
