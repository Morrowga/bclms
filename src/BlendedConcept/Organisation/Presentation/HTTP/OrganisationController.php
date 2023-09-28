<?php

namespace Src\BlendedConcept\Organisation\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Application\DTO\OrganisationData;
use Src\BlendedConcept\Organisation\Application\Mappers\OrganisationAdminMapper;
use Src\BlendedConcept\Organisation\Application\Mappers\OrganisationMapper;
use Src\BlendedConcept\Organisation\Application\Requests\StoreOrganisationRequest;
use Src\BlendedConcept\Organisation\Application\Requests\StoreOrganisationSubscriptionRequest;
use Src\BlendedConcept\Organisation\Application\Requests\UpdateOrganisationRequest;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\DeleteOrganisationCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\StoreOrganisationCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\StoreOrganisationSubscriptionCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\UpdateOrganisationCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\GetOrganisationWithPagination;
use Src\BlendedConcept\Organisation\Domain\Services\OrganisationService;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\Tenant;
use Src\BlendedConcept\System\Application\Policies\OrganisationPolicy;
use Src\Common\Infrastructure\Laravel\Controller;
use Stancl\Tenancy\Database\Models\Domain;
use Symfony\Component\HttpFoundation\Response;

class OrganisationController extends Controller
{
    protected OrganisationService $organisationService;

    public function __construct(OrganisationService $organisationService)
    {
        $this->organisationService = $organisationService;
    }

    public function index()
    {
        // Authorize user to view organisation

        // abort_if(
        //     !(authorize('viewBc', OrganisationPolicy::class) || authorize('view', OrganisationPolicy::class)),
        //     Response::HTTP_FORBIDDEN,
        //     '403 Forbidden'
        // );

        try {

            // Get filters from the request
            $filters = request()->only(['page', 'search', 'perPage', 'filter']);

            //quick create org admin

            // Get organisations with pagination using the provided filters
            $organisations = (new GetOrganisationWithPagination($filters))->handle();

            // Render the organisation index page with the retrieved organisations

            return Inertia::render(config('route.organisations.index'), [
                'organisations' => $organisations['paginate_organisations'],
            ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('organisations.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function create()
    {

        return Inertia::render(config('route.organisations.create'));
    }

    public function edit(OrganisationEloquentModel $organisation)
    {
        $organisation->load('org_admin', 'subscription.b2b_subscription')->loadCount('teachers', 'students');
        // return "hello";


        return Inertia::render(config('route.organisations.edit'), [
            'organisation' => $organisation,
        ]);
    }

    public function testEdit()
    {
        return Inertia::render(config('route.organisations.edit'));
    }

    /**
     * Store a newly created organisation based on the provided request.
     *
     * @param  StoreOrganisationRequest  $request The request object containing the organisation data.
     * @return \Illuminate\Http\RedirectResponse The redirect response after creating the organisation.
     */
    public function store(StoreOrganisationRequest $request)
    {
        try {
            // Abort if the user is not authorized to create organisations
            // abort_if(authorize('create', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $request->validated();
            $quickOrgAdminCreate = $this->organisationService->createQuickOrgAdmin($request);
            $request['user_id'] = $quickOrgAdminCreate->id;
            $newOrganisation = OrganisationMapper::fromRequest($request);
            $newOrganisationAdmin = OrganisationAdminMapper::fromRequest($request);
            $saveOrganisation = (new StoreOrganisationCommand($newOrganisation, $newOrganisationAdmin));
            $saveOrganisation->execute();

            return redirect()->route('organisations.index')->with('successMessage', 'Organisations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('organisations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function update(UpdateOrganisationRequest $request, OrganisationEloquentModel $organisation)
    {
        try {

            // abort_if(authorize('edit', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $quickOrgAdminCreate = $this->organisationService->updateQuickOrgAdmin($organisation, $request);
            $updateOrganisation = OrganisationData::fromRequest($request, $organisation);
            $updateOrganisationcommand = (new updateOrganisationCommand($updateOrganisation));
            $updateOrganisationcommand->execute();
        } catch (\Exception $error) {
            return redirect()
                ->route('organisations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }

        return redirect()->route('organisations.index')->with('successMessage', 'Organisation Updated Successfully!');
    }

    public function show(OrganisationEloquentModel $organisation)
    {
        $organisation->load('org_admin', 'subscription.b2b_subscription')->loadCount('teachers', 'students');

        return Inertia::render(config('route.organisations.show'), [
            'organisation' => $organisation,
        ]);
    }

    public function destroy(OrganisationEloquentModel $organisation)
    {
        try {

            // abort_if(authorize('destroy', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
            // $tenant = Tenant::get();
            // Domain::where('tenant_id', $tenant->id)->delete();
            // $tenant->delete();
            $deleteOrganisation = (new DeleteOrganisationCommand($organisation));
            $deleteOrganisation->execute();

            return redirect()->route('organisations.index')->with('successMessage', 'Organisations Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('organisations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function addSubscription(OrganisationEloquentModel $organisation)
    {
        return Inertia::render(config('route.organisations.addSubscription'), [
            'organisation' => $organisation->load('subscription'),
        ]);
    }

    public function storeSubscription(StoreOrganisationSubscriptionRequest $request)
    {
        try {

            // Abort if the user is not authorized to create organisations
            // abort_if(authorize('create', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $subscription = SubscriptionEloquentModel::findOrFail($request->b2b_subscription['subscription_id']);
            $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
            $saveOrganisation = (new StoreOrganisationSubscriptionCommand($updateSubscription));
            $saveOrganisation->execute();

            return redirect()->route('organisations.index')->with('successMessage', 'Organisations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('organisations.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
