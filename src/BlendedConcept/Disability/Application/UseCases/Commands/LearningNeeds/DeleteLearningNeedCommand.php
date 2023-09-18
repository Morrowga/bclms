<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\LearningNeeds;

use Src\BlendedConcept\Disability\Domain\Repositories\LearningNeedRepositoryInterface;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteLearningNeedCommand implements CommandInterface
{
    private LearningNeedRepositoryInterface $repository;

    public function __construct(
        private readonly LearningNeedEloquentModel $learningNeed,

    ) {
        $this->repository = app()->make(LearningNeedRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteLearningNeed($this->learningNeed);
    }
}
