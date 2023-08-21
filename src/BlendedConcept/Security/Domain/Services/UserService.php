<?php

namespace Src\BlendedConcept\Security\Domain\Services;


use Src\BlendedConcept\Security\Application\Requests\updateUserPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserService
{

    public function changePassword(updateUserPasswordRequest $request)
    {
        $user = auth()->user();
        //  check passord same or not
        if (Hash::check($request->currentpassword, $user->password)) {

            UserEloquentModel::find($user->id)->update([
                'password' => $request->updatedpassword,
            ]);

            return true;
        }

        return false;
    }
}
