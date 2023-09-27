<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands;

use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organisation\Domain\Model\Organisation;
use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreOrganisationCommand implements CommandInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct(
        private readonly Organisation $organisation,
        private readonly Subscription $subscription,
    ) {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createOrganisation($this->organisation, $this->subscription);
    }
}
