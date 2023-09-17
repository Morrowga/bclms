<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\LearningNeeds;

use Src\BlendedConcept\Disability\Application\DTO\LearningNeedData;
use Src\BlendedConcept\Disability\Domain\Repositories\LearningNeedRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateLearningNeedCommand implements CommandInterface
{
    private LearningNeedRepositoryInterface $repository;

    public function __construct(
        private readonly LearningNeedData $learningNeedData,

    ) {
        $this->repository = app()->make(LearningNeedRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateLearningNeed($this->learningNeedData);
    }
}
