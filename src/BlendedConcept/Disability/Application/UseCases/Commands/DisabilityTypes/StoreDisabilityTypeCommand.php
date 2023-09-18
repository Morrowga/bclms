<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\DisabilityTypes;

use Src\BlendedConcept\Disability\Domain\Model\DisabilityType;
use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreDisabilityTypeCommand implements CommandInterface
{
    private DisabilityTypeRepositoryInterface $repository;

    public function __construct(
        private readonly DisabilityType $disabilityType,

    ) {
        $this->repository = app()->make(DisabilityTypeRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createDisability($this->disabilityType);
    }
}
