<?php

namespace Src\BlendedConcept\Disability\Domain\Repositories;

use Src\BlendedConcept\Disability\Application\DTO\DisabilityTypeData;
use Src\BlendedConcept\Disability\Domain\Model\DisabilityType;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;

interface DisabilityTypeRepositoryInterface
{
    public function getDisabilityTypes($filters);
    public function createDisability(DisabilityType $disabilityType);
    public function updateDisability(DisabilityTypeData $disabilityTypeData);
    public function deleteDisability(DisabilityTypeEloquentModel $disabilityType);
}
