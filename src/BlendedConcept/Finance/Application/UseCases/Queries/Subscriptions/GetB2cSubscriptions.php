<?php

namespace Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions;

use Src\BlendedConcept\Finance\Domain\Repositories\SubscriptionRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetB2cSubscriptions implements QueryInterface
{
    private SubscriptionRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(SubscriptionRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getB2cSubscriptions($this->filters);
    }
}
