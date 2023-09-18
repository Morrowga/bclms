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
        );
    }

    public static function toEloquent(Device $device): DeviceEloquentModel
    {
        $DeviceEloquent = new DeviceEloquentModel();

        if ($device->id) {
            $DeviceEloquent = DeviceEloquentModel::query()->findOrFail($device->id);
        }
        $DeviceEloquent->name = $device->name;
        $DeviceEloquent->description = $device->description;
        $DeviceEloquent->status = $device->status;

        return $DeviceEloquent;
    }
}
