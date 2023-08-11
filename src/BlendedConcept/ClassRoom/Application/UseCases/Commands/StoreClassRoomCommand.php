<?php

namespace Src\BlendedConcept\ClassRoom\Application\UseCases\Commands;

use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreClassRoomCommand implements CommandInterface
{
    private ClassRoomRepositoryInterface $repository;

    public function __construct(
        private readonly ClassRoom $classRoom
    ) {
        $this->repository = app()->make(ClassRoomRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createClassRoom($this->classRoom);
    }
}
