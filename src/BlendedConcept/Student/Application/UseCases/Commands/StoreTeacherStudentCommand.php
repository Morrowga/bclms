<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Commands;

use Src\BlendedConcept\Student\Domain\Model\Student;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreTeacherStudentCommand implements CommandInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly Student $student
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->storeTeacherStudent($this->student);
    }
}
