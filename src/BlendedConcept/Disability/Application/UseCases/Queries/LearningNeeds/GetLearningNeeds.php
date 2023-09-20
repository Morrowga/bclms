<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Queries\LearningNeeds;

use Src\BlendedConcept\Disability\Domain\Repositories\LearningNeedRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetLearningNeeds implements QueryInterface
{
    private LearningNeedRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(LearningNeedRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getLearningNeeds($this->filters);
    }
}
