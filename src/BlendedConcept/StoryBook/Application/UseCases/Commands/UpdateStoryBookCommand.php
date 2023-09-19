<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateStoryBookCommand implements CommandInterface
{
    private StoryBookRepositoryInterface $repository;

    public function __construct(
        private readonly StoryBookData $storyBook
    ) {
        $this->repository = app()->make(StoryBookRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateStoryBook($this->storyBook);
    }
}
