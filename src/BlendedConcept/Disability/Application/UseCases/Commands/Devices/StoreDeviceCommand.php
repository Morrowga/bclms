<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices;

use Src\BlendedConcept\Disability\Domain\Model\Entities\Device;
use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreDeviceCommand implements CommandInterface
{
    private DeviceRepositoryInterface $repository;

    public function __construct(
        private readonly Device $device,

    ) {
        $this->repository = app()->make(DeviceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createDevice($this->device);
    }
}
