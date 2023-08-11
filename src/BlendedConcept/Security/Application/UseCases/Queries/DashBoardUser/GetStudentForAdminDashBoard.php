<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\DashBoardUser;

use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudentForAdminDashBoard implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters = []
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudent($this->filters)['default_students'];
    }
}
