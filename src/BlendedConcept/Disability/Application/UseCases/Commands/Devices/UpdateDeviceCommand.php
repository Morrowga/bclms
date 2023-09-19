<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices;

use Src\BlendedConcept\Disability\Application\DTO\DeviceData;
use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateDeviceCommand implements CommandInterface
{
    private DeviceRepositoryInterface $repository;

    public function __construct(
        private readonly DeviceData $deviceData,

    ) {
        $this->repository = app()->make(DeviceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateDevice($this->deviceData);
    }
}
