<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StudentRewards;

use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class DropStickerCommand implements CommandInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(private readonly RewardData $rewardData)
    {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->dropSticker($this->rewardData);
    }
}
