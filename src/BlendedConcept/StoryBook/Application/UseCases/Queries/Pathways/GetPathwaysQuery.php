<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries\Pathways;

use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetPathwaysQuery implements QueryInterface
{
    private PathwayRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(PathwayRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getPathways($this->filters);
    }
}
