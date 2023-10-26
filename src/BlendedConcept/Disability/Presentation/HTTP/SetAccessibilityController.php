<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\Requests\SetDeviceRequest;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices\SetDeviceCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices\GetDevicesWithoutPagination;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;

class SetAccessibilityController
{
    public function index($id)
    {
        $devices = (new GetDevicesWithoutPagination())->handle();

        return Inertia::render(config('route.set_accessibility_device.index'), compact('devices', 'id'));
    }

    public function store(SetDeviceRequest $request, StudentEloquentModel $student_id)
    {

        try {
            $request->validated();
            $find_device = DeviceEloquentModel::find($request->device_id);
            $setDevice = (new SetDeviceCommand($student_id, $find_device));
            $setDevice->execute();

            return redirect()->route('teacher_students.show', $student_id->student_id)->with('successMessage', 'Set Device Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }
}
