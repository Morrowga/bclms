<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Commands;


use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;

class UpdateClassRoomCommand implements CommandInterface
{
    private ClassRoomRepositoryInterface $repository;

    public function __construct(
        private readonly ClassRoomData $classRoomData
    )
    {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateClassRoom($this->classRoomData);
    }
}
