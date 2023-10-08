<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries\TeacherParentDashboard;

use Src\BlendedConcept\System\Domain\Repositories\DashboardRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetRecentStudents implements QueryInterface
{
    private DashboardRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(DashboardRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getRecentStudents($this->filters);
    }
}
