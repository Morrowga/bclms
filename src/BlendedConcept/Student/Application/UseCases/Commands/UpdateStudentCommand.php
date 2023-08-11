<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Commands;

use Src\BlendedConcept\Student\Application\DTO\StudentData;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
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
