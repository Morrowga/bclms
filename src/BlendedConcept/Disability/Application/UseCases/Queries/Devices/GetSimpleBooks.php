<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Queries\Devices;

use Src\BlendedConcept\Disability\Domain\Repositories\DeviceRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetSimpleBooks implements QueryInterface
{
    private DeviceRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(DeviceRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getSimpleBooks();
    }
}
