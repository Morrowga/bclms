<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class GetGameFileDownload implements QueryInterface
{
    private GameRepositoryInterface $repository;

    public function __construct(
        private readonly GameEloquentModel $game
    ) {
        $this->repository = app()->make(GameRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->gameDownload($this->game);
    }
}
