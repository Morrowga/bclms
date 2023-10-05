<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;

class NewOrganisationSubscriptionCommand implements CommandInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct(
        private readonly Subscription $subscription,
    ) {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->newOrganisationSubscription($this->subscription);
    }
}
