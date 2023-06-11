<?php

namespace Src\BlendedConcept\Teacher\Application\Repositories\Eloquent;

use Src\BlendedConcept\Teacher\Domain\Repositories\TeacherRepositoryInterface;
use Src\BlendedConcept\Security\Domain\Model\User;
use Src\BlendedConcept\Security\Application\Mappers\UserMapper;
use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Security\Domain\Resources\UserResource;

class TeacherRepository implements TeacherRepositoryInterface
{

    public function getUsers($filters = [])
    {
        //set roles
        $users = UserResource::collection(UserEloquentModel::filter($filters)
            ->with('roles')
            ->whereHas('roles', function($q)
            {
              return $q->where("name",'Teacher');
            })
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));


        return $users;
    }
    public function createUser(User $user)
    {

        $userEloquent = UserMapper::toEloquent($user);
        $userEloquent->save();
        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $userEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
        }

        $userEloquent->roles()->sync(request('role'));
    }

    //  update user
    public function updateUser(UserData $user)
    {

        $userArray = $user->toArray();
        $updateUserEloquent = UserEloquentModel::query()->findOrFail($user->id);
        $updateUserEloquent->fill($userArray);
        $updateUserEloquent->save();

        //  delete image if reupload or insert if does not exit
        if (request()->hasFile('image') && request()->file('image')->isValid()) {

            $old_image = $updateUserEloquent->getFirstMedia('image');
            if ($old_image != null) {
                $old_image->delete();

                $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
            } else {

                $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
            }
        }


        $updateUserEloquent->roles()->sync(request('role'));
    }
}
