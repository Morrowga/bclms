<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\Organization\Application\Mappers\OrganizationMapper;
use Src\BlendedConcept\Organization\Application\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\Organization\Application\Requests\StoreOrganizationSubscriptionRequest;
use Src\BlendedConcept\Organization\Application\Requests\UpdateOrganizationRequest;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\DeleteOrganizationCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\StoreOrganizationCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\StoreOrganizationSubscriptionCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\UpdateOrganizationCommand;
use Src\BlendedConcept\Organization\Application\UseCases\Queries\GetOrganizationWithPagination;
use Src\BlendedConcept\Organization\Domain\Services\OrganizationService;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\Tenant;
use Src\BlendedConcept\System\Application\Policies\OrganizationPolicy;

use Src\Common\Infrastructure\Laravel\Controller;
use Stancl\Tenancy\Database\Models\Domain;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{
    protected OrganizationService $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    public function index()
    {
        // Authorize user to view organization

        abort_if(
            !(authorize('viewBc', OrganizationPolicy::class) || authorize('view', OrganizationPolicy::class)),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        try {

            // Get filters from the request
            $filters = request()->only(['page', 'search', 'perPage']);

            //quick create org admin

            // Get organizations with pagination using the provided filters
            $organizations = (new GetOrganizationWithPagination($filters))->handle();

            // Render the organization index page with the retrieved organizations

            return Inertia::render(config('route.organizations.index'), [
                'organizations' => $organizations['paginate_organizations'],
            ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('organizations.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function create()
    {

        return Inertia::render(config('route.organizations.create'));
    }

    public function edit(OrganizationEloquentModel $organization)
    {
        $organization->load('org_admin', 'subscription.b2b_subscription')->loadCount('teachers', 'students');
        // return "hello";

        return Inertia::render(config('route.organizations.edit'), [
            'organization' => $organization,
        ]);
    }

    public function testEdit()
    {
        return Inertia::render(config('route.organizations.edit'));
    }

    /**
     * Store a newly created organization based on the provided request.
     *
     * @param  StoreOrganizationRequest  $request The request object containing the organization data.
     * @return \Illuminate\Http\RedirectResponse The redirect response after creating the organization.
     */
    public function store(StoreOrganizationRequest $request)
    {
        try {
            // Abort if the user is not authorized to create organizations
            abort_if(authorize('create', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $request->validated();
            $quickOrgAdminCreate = $this->organizationService->createQuickOrgAdmin($request);
            $request['org_admin_id'] = $quickOrgAdminCreate->id;
            $newOrganizaton = OrganizationMapper::fromRequest($request);
            $newSubscription = SubscriptionMapper::fromRequest($request);
            $saveOrganizaton = (new StoreOrganizationCommand($newOrganizaton, $newSubscription));
            $saveOrganizaton->execute();

            return redirect()->route('organizations.index')->with('successMessage', 'Organizations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('organizations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function update(UpdateOrganizationRequest $request, OrganizationEloquentModel $organization)
    {
        try {

            abort_if(authorize('edit', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $quickOrgAdminCreate = $this->organizationService->updateQuickOrgAdmin($organization, $request);
            $updateOrganization = OrganizationData::fromRequest($request, $organization);
            $updateOrganizationcommand = (new updateOrganizationCommand($updateOrganization));
            $updateOrganizationcommand->execute();
        } catch (\Exception $error) {
            return redirect()
                ->route('organizations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }

        return redirect()->route('organizations.index')->with('successMessage', 'Organization Updated Successfully!');
    }

    public function show(OrganizationEloquentModel $organization)
    {
        $organization->load('org_admin', 'subscription.b2b_subscription')->loadCount('teachers', 'students');

        return Inertia::render(config('route.organizations.show'), [
            'organization' => $organization,
        ]);
    }

    public function destroy(OrganizationEloquentModel $organization)
    {
        try {

            abort_if(authorize('destroy', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
            // $tenant = Tenant::get();
            // Domain::where('tenant_id', $tenant->id)->delete();
            // $tenant->delete();
            $deleteOrganization = (new DeleteOrganizationCommand($organization));
            $deleteOrganization->execute();
            return redirect()->route('organizations.index')->with('successMessage', 'Organizations Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('organizations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function addSubscription(OrganizationEloquentModel $organization)
    {
        return Inertia::render(config('route.organizations.addSubscription'), [
            'organization' => $organization->load('subscription')
        ]);
    }

    public function storeSubscription(StoreOrganizationSubscriptionRequest $request)
    {
        try {

            // Abort if the user is not authorized to create organizations
            // abort_if(authorize('create', OrganizationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $subscription = SubscriptionEloquentModel::findOrFail($request->b2b_subscription['subscription_id']);
            $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
            $saveOrganizaton = (new StoreOrganizationSubscriptionCommand($updateSubscription));
            $saveOrganizaton->execute();

            return redirect()->route('organizations.index')->with('successMessage', 'Organizations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('organizations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
