<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrganizationList implements QueryInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrganizationNameId();
    }
}
