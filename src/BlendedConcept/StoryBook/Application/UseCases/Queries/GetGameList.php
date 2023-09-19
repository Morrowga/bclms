<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries;

use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetGameList implements QueryInterface
{
    private GameRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(GameRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getGameList();
    }
}
