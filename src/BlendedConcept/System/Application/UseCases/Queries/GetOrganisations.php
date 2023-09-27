<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetOrganisations implements QueryInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getOrganisations($this->filters);
    }
}
