<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;

class StoreGameCommand implements CommandInterface
{
    private GameRepositoryInterface $repository;

    public function __construct(
        private readonly Game $game,
    ) {
        $this->repository = app()->make(GameRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createGame($this->game);
    }
}
