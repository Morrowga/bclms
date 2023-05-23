<?php

namespace Src\BlendedConcept\User\Application\UseCases\Queries;

use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetUsersWithPagination implements QueryInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    )
    {
        $this->repository = app()->make(UserRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUsers($this->filters);
    }
}
