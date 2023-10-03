<?php

namespace Src\BlendedConcept\Disability\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Device;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;

class DeviceMapper
{
    public static function fromRequest(Request $request, $device_id = null): Device
    {
        return new Device(
            id: $device_id,
            name: $request->name,
            description: $request->description,
            status: $request->status,
            disability_types: $request->disability_types,
            storybook_id: $request->storybook_id
        );
    }

    public static function toEloquent(Device $device): DeviceEloquentModel
    {
        $deviceEloquent = new DeviceEloquentModel();

        if ($device->id) {
            $deviceEloquent = DeviceEloquentModel::query()->findOrFail($device->id);
        }
        $deviceEloquent->name = $device->name;
        $deviceEloquent->description = $device->description;
        $deviceEloquent->status = $device->status;

        return $deviceEloquent;
    }
}
