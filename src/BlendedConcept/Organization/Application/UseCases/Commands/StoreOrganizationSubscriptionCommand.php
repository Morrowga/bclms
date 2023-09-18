<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands;

use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreOrganizationSubscriptionCommand implements CommandInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(
        private readonly SubscriptionData $subscriptionData,
    ) {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->addOrganizationSubscription($this->subscriptionData);
    }
}
