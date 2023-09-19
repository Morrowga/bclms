<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Pathways;

use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Pathway;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StorePathwayCommand implements CommandInterface
{
    private PathwayRepositoryInterface $repository;

    public function __construct(
        private readonly Pathway $pathway,

    ) {
        $this->repository = app()->make(PathwayRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createPathway($this->pathway);
    }
}
