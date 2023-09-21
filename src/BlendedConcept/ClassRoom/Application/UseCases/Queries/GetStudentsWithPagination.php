<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Queries;

use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudentsWithPagination implements QueryInterface
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
