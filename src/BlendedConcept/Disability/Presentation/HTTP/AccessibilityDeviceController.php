<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\DTO\DeviceData;
use Src\BlendedConcept\Disability\Application\Mappers\DeviceMapper;
use Src\BlendedConcept\Disability\Application\Requests\StoreDeviceRequest;
use Src\BlendedConcept\Disability\Application\Requests\UpdateDeviceRequest;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\DeleteDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\StoreDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\UpdateDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices\GetDevices;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;

class AccessibilityDeviceController
{
    public function index()
    {
        $filters = request(['search', 'page', 'perPage']);
        $Devices = (new GetDevices($filters))->handle();

        return Inertia::render(config('route.disability_type.index'), [
            'disabilityTypes' => $Devices,
        ]);
    }

    public function store(StoreDeviceRequest $request)
    {
        try {
            // Abort if the user is not authorized to create Learning Need
            // abort_if(authorize('create', DevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data

            $request->validated();
            $DeviceRequest = DeviceMapper::fromRequest($request);
            $saveDevice = (new StoreDeviceCommand($DeviceRequest));
            $saveDevice->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Learning Need Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('accessibility_device.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function update(UpdateDeviceRequest $request, $id)
    {

        try {

            $Device = DeviceEloquentModel::findOrFail($id);
            $updateDevice = DeviceData::fromRequest($request, $Device);
            $updateDevicecommand = (new UpdateDeviceCommand($updateDevice));
            $updateDevicecommand->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Learning Need Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('accessibility_device.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function destroy($id)
    {
        try {
            $Device = DeviceEloquentModel::findOrFail($id);
            $deleteDeviceCommand = (new DeleteDeviceCommand($Device));
            $deleteDeviceCommand->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Learning Need Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('accessibility_device.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
