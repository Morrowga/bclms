<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrganisationAdmins implements QueryInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrganisationAdmins();
    }
}
