<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\DisabilityTypes;

use Src\BlendedConcept\Disability\Application\DTO\DisabilityTypeData;
use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateDisabilityTypeCommand implements CommandInterface
{
    private DisabilityTypeRepositoryInterface $repository;

    public function __construct(
        private readonly DisabilityTypeData $disabilityTypeData,

    ) {
        $this->repository = app()->make(DisabilityTypeRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateDisability($this->disabilityTypeData);
    }
}
