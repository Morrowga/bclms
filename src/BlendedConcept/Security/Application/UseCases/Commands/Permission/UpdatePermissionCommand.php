<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\Permission;

use Src\BlendedConcept\Security\Application\DTO\PermissionData;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdatePermissionCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly PermissionData $permissionData
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updatePermission($this->permissionData);
    }
}
