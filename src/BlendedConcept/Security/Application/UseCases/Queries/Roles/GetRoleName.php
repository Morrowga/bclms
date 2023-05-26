<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\Roles;

use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;

use Src\Common\Domain\QueryInterface;

class getRoleName implements QueryInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getRolesName();
    }
}
