<?php

namespace Src\BlendedConcept\Teacher\Application\UseCases\Queries;



use Src\BlendedConcept\Teacher\Domain\Repositories\TeacherRepositoryInterface;
use Src\Common\Domain\QueryInterface;
class GetTeachersWithPagination implements QueryInterface
{
    private TeacherRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    )
    {
        $this->repository = app()->make(TeacherRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUsers($this->filters);
    }
}
