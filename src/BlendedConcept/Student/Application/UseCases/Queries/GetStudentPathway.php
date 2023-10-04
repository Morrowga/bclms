<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Student\Domain\Repositories\StudentRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;

class GetStudentPathway implements QueryInterface
{
    private PathwayRepositoryInterface $repository;

    public function __construct(
    ) {
        $this->repository = app()->make(PathwayRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudentPathway();
    }
}
