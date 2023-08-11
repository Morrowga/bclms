<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Queries;

use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudents implements QueryInterface
{
    private ClassRoomRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudents();
    }
}
