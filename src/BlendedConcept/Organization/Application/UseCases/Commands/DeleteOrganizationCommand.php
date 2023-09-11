<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands;

use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteOrganizationCommand implements CommandInterface
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(
        private readonly OrganizationEloquentModel $organization
    ) {
        $this->repository = app()->make(OrganizationRepositoryInterface::class);
    }

    public function execute()
    {
        $this->organization->delete();
    }
}
