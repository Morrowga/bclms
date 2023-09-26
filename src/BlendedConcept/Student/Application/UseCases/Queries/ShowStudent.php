<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries;

use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class ShowStudent implements QueryInterface
{
    private StudentRepositoryInterface $repository;

    public function __construct(
        private readonly int $id
    ) {
        $this->repository = app()->make(StudentRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->showStudent($this->id);
    }
}
