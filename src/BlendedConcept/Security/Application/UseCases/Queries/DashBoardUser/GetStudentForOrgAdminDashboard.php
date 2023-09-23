<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser;

use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudentForOrgAdminDashboard implements QueryInterface
{
    private ClassRoomRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudents($this->filters);
    }
}
