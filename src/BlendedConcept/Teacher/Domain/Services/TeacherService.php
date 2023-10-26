<?php

namespace Src\BlendedConcept\Teacher\Domain\Services;

use Src\BlendedConcept\Security\Application\Requests\StoreUserRequest;
use Src\BlendedConcept\Teacher\Application\DTO\TeacherData;
use Src\BlendedConcept\Teacher\Application\Mappers\TeacherMapper;
use Src\BlendedConcept\Teacher\Application\Requests\UpdateTeacherRequest;
use Src\BlendedConcept\Teacher\Application\UseCases\Commands\StoreTeacherCommand;
use Src\BlendedConcept\Teacher\Application\UseCases\Commands\UpdateTeacherCommand;

class TeacherService
{
    public function createTeacher(StoreUserRequest $request)
    {
        $request->validated();
        $newUser = TeacherMapper::fromRequest($request);

        $createNewUser = new StoreTeacherCommand($newUser);
        $createNewUser->execute();
    }

    public function updateTeacher(UpdateTeacherRequest $request, $user_id)
    {
        $updateUser = TeacherData::fromRequest($request, $user_id);
        $updatedUserCommand = (new UpdateTeacherCommand($updateUser));

        $updatedUserCommand->execute();
    }

    public function deleteTeacher($teacher)
    {
        $teacher->delete();
    }

    public function updateTeacherStorage($teacher, $request)
    {

        try {
            $teacher->update([
                "allocated_storage_limit" => $request->storage
            ]);
        } catch (\Exception $e) {
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($e->getMessage());
        }
    }
}
