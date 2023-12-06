<?php

namespace Src\BlendedConcept\Organisation\Presentation\HTTP;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Database\Models\Domain;
use Symfony\Component\HttpFoundation\Response;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\Finance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Organisation\Application\DTO\OrganisationData;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;

use Src\BlendedConcept\Organisation\Domain\Services\OrganisationService;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\Tenant;
use Src\BlendedConcept\Organisation\Application\Mappers\OrganisationMapper;
use Src\BlendedConcept\Organisation\Application\Mappers\OrganisationAdminMapper;
use Src\BlendedConcept\Organisation\Application\Requests\StoreOrganisationRequest;
use Src\BlendedConcept\Organisation\Application\Requests\UpdateOrganisationRequest;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;

use Src\BlendedConcept\Organisation\Application\UseCases\Commands\StoreOrganisationCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\DeleteOrganisationCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\UpdateOrganisationCommand;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Application\Requests\StoreOrganisationSubscriptionRequest;
use Src\BlendedConcept\Organisation\Application\UseCases\Queries\GetOrganisationWithPagination;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\NewOrganisationSubscriptionCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\StoreOrganisationSubscriptionCommand;
use Src\BlendedConcept\Organisation\Application\Policies\OrganisationPolicy;

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
        abort_if(authorize('view', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
    public function staff_index()
    {
        // Authorize user to view organisation
        abort_if(authorize('viewBc', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            dd($e);
            return redirect()
                ->route('organisations.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function create()
    {
        abort_if(authorize('create', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render(config('route.organisations.create'));
    }

    public function edit(OrganisationEloquentModel $organisation)
    {
        abort_if(authorize('edit', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organisation->load('org_admin', 'subscription.b2b_subscription')->loadCount('teachers', 'students');
        // return "hello";
        // return $organisation;


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
        abort_if(authorize('create', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function update(UpdateOrganisationRequest $request, OrganisationEloquentModel $organisation)
    {
        abort_if(authorize('update', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // abort_if(authorize('edit', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $quickOrgAdminCreate = $this->organisationService->updateQuickOrgAdmin($organisation, $request);
            $updateOrganisation = OrganisationData::fromRequest($request, $organisation);
            $updateOrganisationcommand = (new updateOrganisationCommand($updateOrganisation));
            $updateOrganisationcommand->execute();
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }

        return redirect()->route('organisations.index')->with('successMessage', 'Organisation Updated Successfully!');
    }

    public function show(OrganisationEloquentModel $organisation)
    {
        abort_if(authorize('show', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usedStorage = MediaEloquentModel::where('collection_name', 'videos')
            ->where('organisation_id', $organisation->id)
            ->where('teacher_id', null)
            ->where('status', 'active')
            ->sum('size');
        $convert_mb = $usedStorage == 0 ? $usedStorage : (int)($usedStorage / 1024 / 1024);
        $organisation->load('org_admin', 'subscription.b2b_subscription')->loadCount('teachers', 'students');

        return Inertia::render(config('route.organisations.show'), [
            'organisation' => $organisation,
            'used_storage' => $convert_mb
        ]);
    }

    public function destroy(OrganisationEloquentModel $organisation)
    {

        abort_if(authorize('destroy', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // abort_if(authorize('destroy', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
            // $tenant = Tenant::get();
            // Domain::where('tenant_id', $tenant->id)->delete();
            // $tenant->delete();
            $type = request('type');
            $deleteOrganisation = (new DeleteOrganisationCommand($organisation));
            $deleteOrganisation->execute();
            if ($type && $type == 'detail') {
                return redirect()->route('organisations.index')->with('successMessage', 'Organisations Deleted Successfully!');
            } else {

                return redirect()->back()->with('successMessage', 'Organisations Deleted Successfully!');
            }
        } catch (\Exception $error) {
            dd($error);
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

            // Validate the request data
            $subscription = SubscriptionEloquentModel::find($request->b2b_subscription['subscription_id']);
            if ($subscription) {
                $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
                $saveOrganisation = (new StoreOrganisationSubscriptionCommand($updateSubscription));
                $saveOrganisation->execute();
            } else {
                $storeSubscription = SubscriptionMapper::fromRequest($request);
                $saveOrganisation = (new NewOrganisationSubscriptionCommand($storeSubscription));
                $saveOrganisation->execute();
            }

            return redirect()->route('staff_organisations')->with('successMessage', 'Organisations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }
}
