<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoryBookVersion;

use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookVersionRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteStorybookVersionCommand implements CommandInterface
{
    private StoryBookVersionRepositoryInterface $repository;

    public function __construct(
        private readonly StoryBookVersionEloquentModel $storybook_version
    ) {
        $this->repository = app()->make(StoryBookVersionRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteStoryBookVersion($this->storybook_version);
    }
}
