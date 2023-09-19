<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes;

use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class ShowDisabilityTypes implements QueryInterface
{
    private DisabilityTypeRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(DisabilityTypeRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->showDisabilityTypes();
    }
}
