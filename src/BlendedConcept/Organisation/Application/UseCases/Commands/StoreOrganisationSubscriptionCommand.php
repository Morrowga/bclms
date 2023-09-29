<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands;

use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreOrganisationSubscriptionCommand implements CommandInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct(
        private readonly SubscriptionData $subscriptionData,
    ) {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->addOrganisationSubscription($this->subscriptionData);
    }
}
