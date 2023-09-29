<?php

namespace Src\BlendedConcept\Organisation\Application\UseCases\Commands\Student;

use Src\BlendedConcept\Organisation\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteStudentCommand implements CommandInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly StudentEloquentModel $student
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteStudent($this->student);
    }
}
