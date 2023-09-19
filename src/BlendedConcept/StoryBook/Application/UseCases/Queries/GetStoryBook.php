<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries;

use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStoryBook implements QueryInterface
{
    private StoryBookRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(StoryBookRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStoryBooks($this->filters);
    }
}
