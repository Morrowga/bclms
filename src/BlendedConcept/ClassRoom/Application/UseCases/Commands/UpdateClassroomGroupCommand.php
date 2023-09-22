<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Commands;

use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomGroupData;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateClassroomGroupCommand implements CommandInterface
{
    private ClassRoomRepositoryInterface $repository;

    public function __construct(
        private readonly ClassRoomGroupData $classroomGroupData
    ) {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateClassRoomGroup($this->classroomGroupData);
    }
}
