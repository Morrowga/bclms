<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\DTO\DeviceData;
use Src\BlendedConcept\Disability\Application\Mappers\DeviceMapper;
use Src\BlendedConcept\Disability\Application\Policies\AccessibilityDevicePolicy;
use Src\BlendedConcept\Disability\Application\Requests\StoreDeviceRequest;
use Src\BlendedConcept\Disability\Application\Requests\UpdateDeviceRequest;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\DeleteDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\StoreDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\UpdateDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices\GetDevices;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices\GetSimpleBooks;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes\GetDisabilityTypeForSelect;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;

class AccessibilityDeviceController
{
    public function index()
    {
        abort_if(authorize('view', AccessibilityDevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = request(['search', 'page', 'perPage', 'filter']);
        $devices = (new GetDevices($filters))->handle();

        return Inertia::render(config('route.accessibility_device.index'), [
            'devices' => $devices,
        ]);
    }

    public function store(StoreDeviceRequest $request)
    {
        // dd($request->all());
        try {
            // Abort if the user is not authorized to create Devices
            abort_if(authorize('store', AccessibilityDevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');


            // Validate the request data

            $request->validated();
            $deviceRequest = DeviceMapper::fromRequest($request);
            $saveDevice = (new StoreDeviceCommand($deviceRequest));
            $saveDevice->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Devices Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function create()
    {
        abort_if(authorize('create', AccessibilityDevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disabilityTypes = (new GetDisabilityTypeForSelect())->handle();
        $books = (new GetSimpleBooks())->handle();

        return Inertia::render(config('route.accessibility_device.create'), [
            'disability_types' => $disabilityTypes,
            'books' => $books
        ]);
    }

    public function edit($id)
    {
        abort_if(authorize('edit', AccessibilityDevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $device = DeviceEloquentModel::with('books')->findOrFail($id);
        $disabilityTypes = (new GetDisabilityTypeForSelect())->handle();
        $books = (new GetSimpleBooks())->handle();
        return Inertia::render(config('route.accessibility_device.edit'), [
            'disability_types' => $disabilityTypes,
            'device' => $device->load('disabilityTypes'),
            'books' => $books
        ]);
    }

    public function update(UpdateDeviceRequest $request, $id)
    {
        abort_if(authorize('update', AccessibilityDevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            $device = DeviceEloquentModel::findOrFail($id);
            $updateDevice = DeviceData::fromRequest($request, $device);
            $updateDevicecommand = (new UpdateDeviceCommand($updateDevice));
            $updateDevicecommand->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Devices Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function destroy($id)
    {
        abort_if(authorize('destroy', AccessibilityDevicePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $device = DeviceEloquentModel::findOrFail($id);
            $deleteDeviceCommand = (new DeleteDeviceCommand($device));
            $deleteDeviceCommand->execute();

            return redirect()->route('accessibility_device.index')->with('successMessage', 'Devices '. strtolower($device->status) .' Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }
}
