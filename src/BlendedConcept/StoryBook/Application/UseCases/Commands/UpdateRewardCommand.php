<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateRewardCommand implements CommandInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(
        private readonly RewardData $reward
    ) {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateReward($this->reward);
    }
}
