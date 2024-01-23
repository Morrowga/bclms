<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\GameScore;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;

class GameScoreCommand implements CommandInterface
{
    private GameRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
    ) {
        $this->repository = app()->make(GameRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->gameScore($this->request);
    }
}
