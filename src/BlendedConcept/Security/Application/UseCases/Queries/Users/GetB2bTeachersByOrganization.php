<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\Users;

use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetB2bTeachersByOrganization implements QueryInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly int $id
    )
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getB2bTeachersByOrganization($this->id);
    }
}
