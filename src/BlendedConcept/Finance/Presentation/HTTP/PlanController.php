<?php

namespace Src\BlendedConcept\Finance\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\FInance\Application\DTO\PlanData;
use Src\BlendedConcept\Finance\Application\Mappers\PlanMapper;

use Src\BlendedConcept\Finance\Application\Policies\PlanPolicy;
use Src\BlendedConcept\Finance\Application\Requests\StorePlanRequest;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Plans\GetPlanWithPagination;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans\StorePlanCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Plans\UpdatePlanCommand;
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
        try {
            // Abort if the user is not authorized to create organizations
            abort_if(authorize('create', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

    public function update(StorePlanRequest $request, PlanEloquentModel $plan)
    {
        abort_if(authorize('edit', PlanPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $updatePlan = PlanData::fromRequest($request, $plan);
        $updatePlancommand = (new UpdatePlanCommand($updatePlan));
        $updatePlancommand->execute();

        return redirect()->route('plans.index')->with('successMessage', 'Plan Updated Successfully!');
    }
    public function planfororg()
    {
        return Inertia::render(config('route.plans.planorg'));
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function edit()
    {
        // dd('hello');
        return Inertia::render(config('route.plans.edit'));
    }
}
