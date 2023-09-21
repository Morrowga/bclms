<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands\Student;

use Src\BlendedConcept\Organization\Domain\Model\Entities\Student;
use Src\BlendedConcept\Organization\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class CreateStudentCommand implements CommandInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly Student $student
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createStudent($this->student);
    }
}
