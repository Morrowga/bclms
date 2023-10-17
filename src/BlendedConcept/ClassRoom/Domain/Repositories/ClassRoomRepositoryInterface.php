<?php

namespace Src\BlendedConcept\ClassRoom\Domain\Repositories;

use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomGroupData;
use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\ClassRoom\Domain\Model\Entities\ClassRoomGroup;

interface ClassRoomRepositoryInterface
{
    public function getClassRooms($filters);

    public function createClassRoom(ClassRoom $classRoom);

    public function updateClassRoom(ClassRoomData $classRoomData);

    public function getTeachers($filters);

    public function getStudents($filters);

    public function getOrgTeacherClassrooms($filters);

    public function createClassRoomGroup(ClassRoomGroup $classroomGroup);

    public function updateClassRoomGroup(ClassRoomGroupData $classroomGroupData);
}
