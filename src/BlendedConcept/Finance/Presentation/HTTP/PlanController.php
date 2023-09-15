<?php

namespace Src\BlendedConcept\Finance\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\FInance\Application\DTO\PlanData;
use Src\BlendedConcept\Finance\Application\Mappers\PlanMapper;
use Src\BlendedConcept\Finance\Application\Policies\PlanPolicy;
use Src\BlendedConcept\Finance\Application\Requests\ChangeStatusPlanRequest;
use Src\BlendedConcept\Finance\Application\Requests\StorePlanRequest;
use Src\BlendedConcept\Finance\Application\Requests\UpdatePlanRequest;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans\ChangeStatusCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans\DeletePlanCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans\StorePlanCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans\UpdatePlanCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Plans\GetPlanWithPagination;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanController
{
    public function index()
    {
        // Authorize user to view organization

        abort_if(authorize('view', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $filters = request()->only(['page', 'search', 'perPage', 'status']);
            $plans = (new GetPlanWithPagination($filters))->handle($filters);

            return Inertia::render(config('route.plans.index'), [
                'plans' => $plans['paginate_plans'],
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('plans.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function create()
    {
        return Inertia::render(config('route.plans.create'));
    }

    public function store(StorePlanRequest $request)
    {
        // Abort if the user is not authorized to create organizations
        // abort_if(authorize('create', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Validate the request data
            $request->validated();
            $newOrganizaton = PlanMapper::fromRequest($request);
            $saveOrganizaton = (new StorePlanCommand($newOrganizaton));
            $saveOrganizaton->execute();

            return redirect()->route('plans.index')->with('successMessage', 'plans Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('plans.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function update(UpdatePlanRequest $request, PlanEloquentModel $plan)
    {
        // abort_if(authorize('edit', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $updatePlan = PlanData::fromRequest($request, $plan);
            $updatePlancommand = (new UpdatePlanCommand($updatePlan));
            $updatePlancommand->execute();

            return redirect()->route('plans.index')->with('successMessage', 'Plan Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('plans.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function planfororg()
    {
        return Inertia::render(config('route.plans.planorg'));
    }

    public function show(PlanEloquentModel $plan)
    {
        return Inertia::render(config('route.plans.show'), [
            'plan' => $plan,
        ]);
    }

    public function edit(PlanEloquentModel $plan)
    {

        return Inertia::render(config('route.plans.edit'), [
            'plan' => $plan,
        ]);
    }

    public function destroy(PlanEloquentModel $plan)
    {
        // abort_if(authorize('destroy', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $deletePlan = (new DeletePlanCommand($plan));
            $deletePlan->execute();
        } catch (\Exception $e) {
            return redirect()
                ->route('plans.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function changeStatus(ChangeStatusPlanRequest $request, PlanEloquentModel $plan)
    {
        // abort_if(authorize('edit', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $updatePlancommand = (new ChangeStatusCommand($request, $plan));
            $updatePlancommand->execute();
            $message = $request->status == 'ACTIVE' ? 'activated' : 'inactived';

            return redirect()->route('plans.index')->with('successMessage', "Subscription plan has been set $message");
        } catch (\Exception $e) {
            return redirect()
                ->route('plans.index')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }
}
