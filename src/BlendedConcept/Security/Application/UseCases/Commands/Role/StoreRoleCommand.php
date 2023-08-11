<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\Role;

use Src\BlendedConcept\Security\Domain\Model\Entities\Role;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreRoleCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly Role $role
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createRole($this->role);
    }
}
