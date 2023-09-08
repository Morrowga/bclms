<?php

namespace Src\BlendedConcept\Security\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Domain\Model\User;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserMapper
{
    public static function fromRequest(Request $request, $user_id = null): User
    {
        return new User(
            id: $user_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            email: $request->email,
            password: $request->password,
            email_verification_send_on: $request->email_verification_send_on,
            contact_number: $request->contact_number,
            status: $request->status,
            profile_pic: $request->profile_pic,
        );
    }

    public static function toEloquent(User $user): UserEloquentModel
    {
        $UserEloquent = new UserEloquentModel();

        if ($user->id) {
            $UserEloquent = UserEloquentModel::query()->findOrFail($user->id);
        }
        $UserEloquent->first_name = $user->first_name;
        $UserEloquent->last_name = $user->last_name;
        $UserEloquent->email = $user->email;
        $UserEloquent->password = $user->password;
        $UserEloquent->email_verification_send_on = $user->email_verification_send_on;
        $UserEloquent->contact_number = $user->contact_number;
        $UserEloquent->status = $user->status;
        $UserEloquent->profile_pic = $user->profile_pic;

        return $UserEloquent;
    }
}
