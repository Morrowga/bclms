<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands;

use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateOrganizationCommand implements CommandInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(
        private readonly OrganizationData $organizationData,
    ) {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateOrganization($this->organizationData);
    }
}
