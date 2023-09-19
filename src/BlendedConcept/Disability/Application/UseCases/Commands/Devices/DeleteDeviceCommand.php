<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices;

use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteDeviceCommand implements CommandInterface
{
    private DeviceRepositoryInterface $repository;

    public function __construct(
        private readonly DeviceEloquentModel $device,

    ) {
        $this->repository = app()->make(DeviceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteDevice($this->device);
    }
}
