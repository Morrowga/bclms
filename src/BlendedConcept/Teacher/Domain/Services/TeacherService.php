<?php

namespace Src\BlendedConcept\Teacher\Domain\Services;

use Src\BlendedConcept\Security\Application\Requests\StoreUserRequest;
use Src\BlendedConcept\Security\Application\Mappers\UserMapper;
use Src\BlendedConcept\Security\Application\Requests\UpdateUserRequest;
use Src\BlendedConcept\Security\Application\UseCases\Commands\User\StoreUserCommand;
use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Application\UseCases\Commands\User\UpdateUserCommand;


class TeacherService
{
    public function createUser(StoreUserRequest $request)
    {
        $request->validated();
        $newUser = UserMapper::fromRequest($request);

        $createNewUser = new StoreUserCommand($newUser);
        $createNewUser->execute();
    }

    public function updateUser(UpdateUserRequest $request, $user_id)
    {
        $updateUser = UserData::fromRequest($request, $user_id);
        $updatedUserCommand = (new UpdateUserCommand($updateUser));

        $updatedUserCommand->execute();
    }

    public function deleteUser($user)
    {
        $user->delete();
    }

}
