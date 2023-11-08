<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class AssignGameCommand implements CommandInterface
{
    private GameRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(GameRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->assignToStudent();
    }
}
