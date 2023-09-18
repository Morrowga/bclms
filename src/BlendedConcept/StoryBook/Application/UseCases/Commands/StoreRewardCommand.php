<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Reward;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreRewardCommand implements CommandInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(
        private readonly Reward $reward
    ) {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createReward($this->reward);
    }
}
