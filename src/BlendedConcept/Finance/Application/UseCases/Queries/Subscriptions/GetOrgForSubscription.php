<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions;

use Src\BlendedConcept\Finance\Domain\Repositories\SubscriptionRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrgForSubscription implements QueryInterface
{
    private SubscriptionRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(SubscriptionRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrgForSubscription();
    }
}
