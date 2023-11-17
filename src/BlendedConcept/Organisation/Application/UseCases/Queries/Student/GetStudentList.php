<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Queries\Student;

use Src\BlendedConcept\ClassRoom\Application\Repositories\Eloquent\ClassRoomRepository;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\Organisation\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudentList implements QueryInterface
{
    private ClassRoomRepository $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudents($this->filters);
    }
}
