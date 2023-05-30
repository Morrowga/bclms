<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\GetOrganizationWithPagination;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Application\Mappers\OrganizationMapper;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\StoreOrganizationCommand;
use Src\BlendedConcept\System\Application\Policies\OrganizationPolicy;
use Src\BlendedConcept\System\Application\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\System\Application\Requests\UpdateOrganizationRequest;
use Src\Common\Infrastructure\Laravel\Controller;
use Symfony\Component\HttpFoundation\Response;
class OrganizationController extends Controller
{
    private $organizationInterface;
    public function __construct(OrganizationRepositoryInterface $organizationInterface)
    {
        $this->organizationInterface = $organizationInterface;
    }


    public function index()
    {
        // Authorize user to view organization

        abort_if(authorize('view', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');


        try {

            // Get filters from the request
            $filters = request()->only(['page', 'search', 'perPage']);

            // Get organizations with pagination using the provided filters
            $organizations = (new GetOrganizationWithPagination($filters))->handle();

            // Render the organization index page with the retrieved organizations
            return Inertia::render(config('route.organizations'),[
                'organizations' => $organizations['paginate_organizations']
            ]);
        } catch (\Exception $e) {

            return Inertia::render(config('route.organization'), [
                'systemErrorMessage' => $e->getMessage()
            ]);
        }
    }


    public function create()
    {
        abort(404);
    }



    public function store(StoreOrganizationRequest $request)
    {

        abort_if(authorize('create', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(authorize('edit', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->organizationInterface->updateOrganization($request, $organization);
        return redirect()->route('organizations.index')->with("successMessage", "Organization Updated Successfully!");
    }

    public function show()
    {
        abort(404);
    }

    public function destroy(OrganizationEloquentModel $organization)
    {
        abort_if(authorize('destroy', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $organization->delete();
        return redirect()->route('organizations.index')->with("successMessage", "Organizations Deleted Successfully!");
    }
}
