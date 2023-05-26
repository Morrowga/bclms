<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\Role;


use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Security\Application\DTO\RoleData;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;

class UpdateRoleCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly RoleData $roleData
    )
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateRole($this->roleData);
    }
}
