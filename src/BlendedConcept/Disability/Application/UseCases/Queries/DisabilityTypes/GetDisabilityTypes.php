<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Queries\DisabilityTypes;

use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetDisabilityTypes implements QueryInterface
{
    private DisabilityTypeRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(DisabilityTypeRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getDisabilityTypes($this->filters);
    }
}
