<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\Users;

use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetUsersWithPagination implements QueryInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUsers($this->filters);
    }
}
