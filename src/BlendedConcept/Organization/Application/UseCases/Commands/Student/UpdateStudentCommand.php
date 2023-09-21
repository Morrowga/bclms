<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands\Student;

use Src\BlendedConcept\Organization\Application\DTO\StudentData;
use Src\BlendedConcept\Organization\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateStudentCommand implements CommandInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly StudentData $studentData
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateStudent($this->studentData);
    }
}
