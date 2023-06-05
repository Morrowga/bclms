<?php

namespace Src\BlendedConcept\Teacher\Application\UseCases\Queries;


use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\QueryInterface;
class GetTeachersWithPagination implements QueryInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    )
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUsers($this->filters);
    }
}
