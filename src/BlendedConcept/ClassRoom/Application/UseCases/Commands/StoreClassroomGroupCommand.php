<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Commands;

use Src\BlendedConcept\Classroom\Domain\Model\Entities\ClassroomGroup;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassroomGroupEloquentModel;
use Src\Common\Domain\CommandInterface;

class StoreClassroomGroupCommand implements CommandInterface
{
    private ClassRoomRepositoryInterface $repository;

    public function __construct(
        private readonly ClassroomGroup $classroomGroup
    ) {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createClassRoomGroup($this->classroomGroup);
    }
}
