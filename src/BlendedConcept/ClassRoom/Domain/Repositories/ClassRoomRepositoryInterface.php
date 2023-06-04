<?php

namespace Src\BlendedConcept\ClassRoom\Domain\Repositories;

use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;


interface ClassRoomRepositoryInterface
{

    public function getClassRooms($filers);
    public function createClassRoom(ClassRoom $classRoom);
    public function updateClassRoom(ClassRoomData $classRoomData);
}
