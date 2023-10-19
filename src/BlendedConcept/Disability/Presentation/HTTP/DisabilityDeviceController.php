<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\DTO\DisabilityTypeData;
use Src\BlendedConcept\Disability\Application\Mappers\DisabilityTypeMapper;
use Src\BlendedConcept\Disability\Application\Policies\DisabilityTypePolicy;
use Src\BlendedConcept\Disability\Application\Requests\StoreDisabilityTypeRequest;
use Src\BlendedConcept\Disability\Application\Requests\UpdateDisabilityTypeRequest;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\DisabilityTypes\DeleteDisabilityTypeCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\DisabilityTypes\StoreDisabilityTypeCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\DisabilityTypes\UpdateDisabilityTypeCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes\GetDisabilityTypes;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;

class DisabilityDeviceController
{
    public function index()
    {
        $filters = request(['search', 'page', 'perPage']);
        $disabilityTypes = (new GetDisabilityTypes($filters))->handle();

        return Inertia::render(config('route.disability_type.index'), [
            'disabilityTypes' => $disabilityTypes,
        ]);
    }

    public function store(StoreDisabilityTypeRequest $request)
    {
        try {
            // Abort if the user is not authorized to create organisations
            // abort_if(authorize('create', DisabilityTypePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $request->validated();
            $disabilityTypeRequest = DisabilityTypeMapper::fromRequest($request);
            $saveDisabilityType = (new StoreDisabilityTypeCommand($disabilityTypeRequest));
            $saveDisabilityType->execute();

            return redirect()->route('disability_type.index')->with('successMessage', 'Disability Type Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('disability_type.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function create()
    {
        return Inertia::render(config('route.plans.create'));
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function edit()
    {
        return Inertia::render(config('route.plans.edit'));
    }

    public function update(UpdateDisabilityTypeRequest $request, DisabilityTypeEloquentModel $disabilityType)
    {

        try {
            $updateDisabilityType = DisabilityTypeData::fromRequest($request, $disabilityType);
            $updateDisabilityTypecommand = (new UpdateDisabilityTypeCommand($updateDisabilityType));
            $updateDisabilityTypecommand->execute();

            return redirect()->route('disability_type.index')->with('successMessage', 'Disability Type Updated Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('disability_type.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function destroy(DisabilityTypeEloquentModel $disabilityType)
    {
        try {

            $updateDisabilityTypecommand = (new DeleteDisabilityTypeCommand($disabilityType));
            $updateDisabilityTypecommand->execute();

            return redirect()->route('disability_type.index')->with('successMessage', 'Disability Type Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('disability_type.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
