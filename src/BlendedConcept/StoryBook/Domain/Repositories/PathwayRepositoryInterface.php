<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Src\BlendedConcept\StoryBook\Application\DTO\PathwayData;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Pathway;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\PathwayEloquentModel;

interface PathwayRepositoryInterface
{
    public function getPathways($filters);

    public function createPathway(Pathway $pathway);

    public function updatePathway(PathwayData $pathwayData);

    public function deletePathway(PathwayEloquentModel $pathway);
}
