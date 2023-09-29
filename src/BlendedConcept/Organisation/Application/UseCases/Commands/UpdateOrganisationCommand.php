<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands;

use Src\BlendedConcept\Organisation\Application\DTO\OrganisationData;
use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateOrganisationCommand implements CommandInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct(
        private readonly OrganisationData $organisationData,
    ) {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateOrganisation($this->organisationData);
    }
}
