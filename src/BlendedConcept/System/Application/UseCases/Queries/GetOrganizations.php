<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrganizations implements QueryInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrganizations($this->filters);
    }
}
