<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetSuperAdminListCount implements QueryInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUserListCount();
    }
}
