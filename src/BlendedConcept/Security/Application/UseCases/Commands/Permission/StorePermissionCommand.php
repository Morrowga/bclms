<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\Permission;

use Src\BlendedConcept\Security\Domain\Model\Permission;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StorePermissionCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly Permission $permission
    )
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createPermission($this->permission);
    }
}
