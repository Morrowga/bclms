<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Src\BlendedConcept\StoryBook\Domain\Model\StoryBook;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class CreateStoreStoryBookCommand implements CommandInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(
        private readonly StoryBook $storyBook
    ) {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createReward($this->storyBook);
    }
}
