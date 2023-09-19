<?php

namespace Src\BlendedConcept\Security\Domain\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Src\BlendedConcept\Security\Application\Requests\updateUserPasswordRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserService
{
    public function changePassword(Request $request)
    {
        $user = auth()->user();
        //  check passord same or not
        if (Hash::check($request->currentpassword, $user->password)) {

            UserEloquentModel::find($user->id)->update([
                'password' => $request->updatedpassword,
            ]);

            return true;
        }

        throw ValidationException::withMessages([
            'currentpassword' => 'Old password is not correct.',
        ]);
    }
}
