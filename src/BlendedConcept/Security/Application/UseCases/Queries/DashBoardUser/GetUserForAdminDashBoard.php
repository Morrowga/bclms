<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser;

use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;

use Src\Common\Domain\QueryInterface;

class GetUserForAdminDashBoard implements QueryInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUserForDashBoard();
    }
}
