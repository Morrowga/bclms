<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\LearningNeeds;

use Src\BlendedConcept\Disability\Domain\Model\Entities\LearningNeed;
use Src\BlendedConcept\Disability\Domain\Repositories\LearningNeedRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreLearningNeedCommand implements CommandInterface
{
    private LearningNeedRepositoryInterface $repository;

    public function __construct(
        private readonly LearningNeed $learningNeed,

    ) {
        $this->repository = app()->make(LearningNeedRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createLearningNeed($this->learningNeed);
    }
}
