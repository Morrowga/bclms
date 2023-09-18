<?php

namespace Src\BlendedConcept\Disability\Domain\Repositories;

use Src\BlendedConcept\Disability\Application\DTO\LearningNeedData;
use Src\BlendedConcept\Disability\Domain\Model\Entities\LearningNeed;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;

interface LearningNeedRepositoryInterface
{
    public function getLearningNeeds($filters);

    public function createLearningNeed(LearningNeed $LearningNeed);

    public function updateLearningNeed(LearningNeedData $LearningNeedData);

    public function deleteLearningNeed(LearningNeedEloquentModel $LearningNeed);
}
