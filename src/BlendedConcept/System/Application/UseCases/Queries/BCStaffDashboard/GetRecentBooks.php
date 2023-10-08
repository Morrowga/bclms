<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries\BCStaffDashboard;

use Src\BlendedConcept\System\Domain\Repositories\DashboardRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetRecentBooks implements QueryInterface
{
    private DashboardRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(DashboardRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getRecentBooks();
    }
}
