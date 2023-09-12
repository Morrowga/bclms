<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands;

use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreOrganizationCommand implements CommandInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(
        private readonly Organization $organization,
        private readonly Subscription $subscription,
    ) {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createOrganization($this->organization, $this->subscription);
    }
}
