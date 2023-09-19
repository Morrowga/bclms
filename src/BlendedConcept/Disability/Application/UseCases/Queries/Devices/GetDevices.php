<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices;

use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetDevices implements QueryInterface
{
    private DeviceRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(DeviceRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getDevices($this->filters);
    }
}
