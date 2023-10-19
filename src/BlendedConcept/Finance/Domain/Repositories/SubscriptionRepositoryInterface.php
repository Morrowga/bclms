<?php

namespace Src\BlendedConcept\Finance\Domain\Repositories;

use Src\BlendedConcept\Finance\Application\DTO\SubscriptionData;

interface SubscriptionRepositoryInterface
{
    public function getB2bSubscriptions($filter);

    public function getB2cSubscriptions($filter);

    public function updateB2bSubscription(SubscriptionData $subscriptionData);

    public function updateB2cSubscription(SubscriptionData $subscriptionData);
}
