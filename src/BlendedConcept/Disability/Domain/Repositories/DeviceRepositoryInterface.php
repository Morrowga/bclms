<?php

namespace Src\BlendedConcept\Disability\Domain\Repositories;

use Src\BlendedConcept\Disability\Application\DTO\DeviceData;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Device;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\StudentEloquentModel;

interface DeviceRepositoryInterface
{
    public function getDevices($filters);

    public function createDevice(Device $device);

    public function updateDevice(DeviceData $deviceData);

    public function deleteDevice(DeviceEloquentModel $device);

    public function setDevice(StudentEloquentModel $student, DeviceEloquentModel $device);
}
