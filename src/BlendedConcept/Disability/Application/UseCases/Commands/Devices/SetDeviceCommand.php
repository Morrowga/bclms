<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Devices;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Disability\Application\DTO\DeviceData;
use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\StudentEloquentModel;

class SetDeviceCommand implements CommandInterface
{
    private DeviceRepositoryInterface $repository;

    public function __construct(
        private readonly StudentEloquentModel $student,
        private readonly DeviceEloquentModel $device,

    ) {
        $this->repository = app()->make(DeviceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->setDevice($this->student, $this->device);
    }
}
