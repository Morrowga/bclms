<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Queries;

use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrganizationWithCount implements QueryInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrganizationNameWithCount();
    }
}
