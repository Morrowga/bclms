<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\GetOrganizationWithPagination;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Application\Mappers\OrganizationMapper;
use Src\BlendedConcept\Security\Application\UseCases\Commands\Permission\StoreOrganizationCommand;
use Src\BlendedConcept\System\Domain\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\System\Domain\Requests\UpdateOrganizationRequest;
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
        try {
            // Authorize user to view organization
            $this->authorize('view', OrganizationEloquentModel::class);

            // Get filters from the request
            $filters = request()->only(['page', 'search', 'perPage']);

            // Get organizations with pagination using the provided filters
            $organizations = (new GetOrganizationWithPagination($filters))->handle();

            // Render the organization index page with the retrieved organizations
            return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Organization/Index', [
                'organizations' => $organizations['paginate_organizations']
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public function create()
    {
        abort(404);
    }



    public function store(StoreOrganizationRequest $request)
    {
        $this->authorize('create', Organization::class);
        $request->validated();

        $newOrganizaton = OrganizationMapper::fromRequest($request);
        $saveOrganizaton = (new StoreOrganizationCommand($newOrganizaton));
        $saveOrganizaton->execute();
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Created Successfully!");
    }

    public function edit()
    {
        abort(404);
    }

    public function update(UpdateOrganizationRequest $request, OrganizationEloquentModel $organization)
    {
        $this->authorize('edit', Organization::class);
        $this->organizationInterface->updateOrganization($request, $organization);
        return redirect()->route('organizations.index')->with("successMessage", "Organization Updated Successfully!");
    }

    public function show()
    {
        abort(404);
    }

    public function destroy(OrganizationEloquentModel $organization)
    {
        $this->authorize('destroy', Organization::class);
        $organization->delete();
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Deleted Successfully!");
    }
}
