<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Commands\Subscriptions;

use Src\BlendedConcept\Finance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Domain\Repositories\SubscriptionRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateB2cSubscriptionCommand implements CommandInterface
{
    private SubscriptionRepositoryInterface $repository;

    public function __construct(
        private readonly SubscriptionData $subscriptionData,
    ) {
        $this->repository = app()->make(SubscriptionRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateB2cSubscription($this->subscriptionData);
    }
}
