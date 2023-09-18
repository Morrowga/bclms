<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\DisabilityTypes;

use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteDisabilityTypeCommand implements CommandInterface
{
    private DisabilityTypeRepositoryInterface $repository;

    public function __construct(
        private readonly DisabilityTypeEloquentModel $disabilityType,

    ) {
        $this->repository = app()->make(DisabilityTypeRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteDisability($this->disabilityType);
    }
}
