<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\StoryBook\Application\DTO\GameData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;

class UpdateGameCommand implements CommandInterface
{
    private GameRepositoryInterface $repository;

    public function __construct(
        private readonly GameData $game
    ) {
        $this->repository = app()->make(GameRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateGame($this->game);
    }
}
