<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoryBookVersion;

use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookVersionData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookVersionRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateStorybookVersionCommand implements CommandInterface
{
    private StoryBookVersionRepositoryInterface $repository;

    public function __construct(
        private readonly StoryBookVersionData $storyBookData
    ) {
        $this->repository = app()->make(StoryBookVersionRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateStorybookVersion($this->storyBookData);
    }
}
