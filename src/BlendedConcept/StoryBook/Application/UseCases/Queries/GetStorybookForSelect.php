<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries;

use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStorybookForSelect implements QueryInterface
{
    private StoryBookRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(StoryBookRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStoryBooksForSelect();
    }
}
