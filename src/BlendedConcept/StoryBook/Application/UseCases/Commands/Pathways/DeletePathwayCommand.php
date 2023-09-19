<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Pathways;

use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\PathwayEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeletePathwayCommand implements CommandInterface
{
    private PathwayRepositoryInterface $repository;

    public function __construct(
        private readonly PathwayEloquentModel $pathway,

    ) {
        $this->repository = app()->make(PathwayRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deletePathway($this->pathway);
    }
}
