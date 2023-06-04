<?php

namespace Src\BlendedConcept\ClassRoom\Domain\Services;

use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomData;
use Src\BlendedConcept\ClassRoom\Application\Mappers\ClassRoomMapper;
use Src\BlendedConcept\ClassRoom\Application\Requests\storeClassRoomRequest;
use Src\BlendedConcept\ClassRoom\Application\Requests\updateClassRoomRequest;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Commands\StoreClassRoomCommand;
use Src\BlendedConcept\ClassRoom\Application\UseCases\Commands\UpdateClassRoomCommand;


class ClassRoomService
{
    public function createClassRoom(storeClassRoomRequest $request)
    {
        $request->validated();
        $newUser = ClassRoomMapper::fromRequest($request);

        $createNewUser = new StoreClassRoomCommand($newUser);
        $createNewUser->execute();
    }

    public function updateClassRoom(updateClassRoomRequest $request, $classroom_id)
    {
        $updateClassRoom = ClassRoomData::fromRequest($request, $classroom_id);
        $updateClassRoom = (new UpdateClassRoomCommand($updateClassRoom));
        $updateClassRoom->execute();
    }

    public function deleteClassRoom($classroom)
    {
        $classroom->delete();
    }

}
