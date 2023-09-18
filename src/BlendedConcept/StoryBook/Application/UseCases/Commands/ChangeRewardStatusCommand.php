<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;
use Src\Common\Domain\CommandInterface;

class ChangeRewardStatusCommand implements CommandInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(
        private readonly RewardEloquentModel $reward
    ) {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->changeStatus($this->reward);
    }
}
