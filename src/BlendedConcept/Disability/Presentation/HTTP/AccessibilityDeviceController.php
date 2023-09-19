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
use Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes\GetDisabilityTypeForSelect;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;

class AccessibilityDeviceController
{
    public function index()
    {
        $filters = request(['search', 'page', 'perPage']);
        $devices = (new GetDevices($filters))->handle();

        return Inertia::render(config('route.accessibility_device.index'), [
            'devices' => $devices,
        ]);
    }

    public function store(StoreDeviceRequest $request)
    {

        try {
            // Abort if the user is not authorized to create Devices
            // abort_if(authorize('create', DevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data

            $request->validated();
            $deviceRequest = DeviceMapper::fromRequest($request);
            $saveDevice = (new StoreDeviceCommand($deviceRequest));
            $saveDevice->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Devices Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('accessibility_device.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function create()
    {
        $disabilityTypes = (new GetDisabilityTypeForSelect())->handle();

        return Inertia::render(config('route.accessibility_device.create'), [
            'disability_types' => $disabilityTypes,
        ]);
    }

    public function edit($id)
    {
        $device = DeviceEloquentModel::findOrFail($id);
        $disabilityTypes = (new GetDisabilityTypeForSelect())->handle();

        return Inertia::render(config('route.accessibility_device.edit'), [
            'disability_types' => $disabilityTypes,
            'device' => $device->load('disabilityTypes'),
        ]);
    }

    public function update(UpdateDeviceRequest $request, $id)
    {

        try {

            $device = DeviceEloquentModel::findOrFail($id);
            $updateDevice = DeviceData::fromRequest($request, $device);
            $updateDevicecommand = (new UpdateDeviceCommand($updateDevice));
            $updateDevicecommand->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Devices Created Successfully!');
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
            $device = DeviceEloquentModel::findOrFail($id);
            $deleteDeviceCommand = (new DeleteDeviceCommand($device));
            $deleteDeviceCommand->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Devices Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('accessibility_device.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
