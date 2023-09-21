<?php

namespace Src\BlendedConcept\Organization\Application\UseCases\Commands\Student;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Student;
use Src\BlendedConcept\Organization\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\StudentEloquentModel;

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
