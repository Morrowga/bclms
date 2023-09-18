<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Pathways;

use Src\BlendedConcept\StoryBook\Application\DTO\PathwayData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdatePathwayCommand implements CommandInterface
{
    private PathwayRepositoryInterface $repository;

    public function __construct(
        private readonly PathwayData $pathwayData,

    ) {
        $this->repository = app()->make(PathwayRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updatePathway($this->pathwayData);
    }
}
