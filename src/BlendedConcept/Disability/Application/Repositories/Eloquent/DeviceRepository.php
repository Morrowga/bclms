<?php

namespace Src\BlendedConcept\Disability\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Disability\Application\DTO\DeviceData;
use Src\BlendedConcept\Disability\Application\Mappers\DeviceMapper;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Device;
use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Resources\DeviceResource;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;

class DeviceRepository implements DeviceRepositoryInterface
{
    public function getDevices($filters)
    {

        $devices = DeviceResource::collection(DeviceEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $devices;
    }

    public function createDevice(Device $device)
    {
        DB::beginTransaction();
        try {
            $deviceEloquent = DeviceMapper::toEloquent($device);
            $deviceEloquent->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function updateDevice(DeviceData $deviceData)
    {
        DB::beginTransaction();
        try {
            $deviceArray = $deviceData->toArray();
            $deviceEloquent = DeviceEloquentModel::findOrFail($deviceData->id);
            $deviceEloquent->fill($deviceArray);
            $deviceEloquent->update();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function deleteDevice(DeviceEloquentModel $device)
    {
        DB::beginTransaction();
        try {
            $device->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
