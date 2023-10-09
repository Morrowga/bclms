<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StudentRewards;

use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;
use Src\Common\Domain\CommandInterface;

class OwnStickerCommand implements CommandInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(private readonly RewardEloquentModel $reward)
    {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->ownSticker($this->reward);
    }
}
