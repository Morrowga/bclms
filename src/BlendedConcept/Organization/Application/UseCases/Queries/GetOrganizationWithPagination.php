<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries;

use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\QueryInterface;
class GetOrganizationWithPagination implements QueryInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    )
    {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrganizations($this->filters);
    }
}
