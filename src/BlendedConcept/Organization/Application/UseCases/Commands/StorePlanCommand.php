<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands;

use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\Common\Domain\CommandInterface;

class StorePlanCommand implements CommandInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(
        private readonly Organization $organization
    )
    {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createOrganization($this->organization);
    }
}
