<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands;

use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteOrganisationCommand implements CommandInterface
{
    private OrganisationRepositoryInterface $repository;

    public function __construct(
        private readonly OrganisationEloquentModel $organisation
    ) {
        $this->repository = app()->make(OrganisationRepositoryInterface::class);
    }

    public function execute()
    {
        $this->repository->delete($this->organisation);
    }
}
