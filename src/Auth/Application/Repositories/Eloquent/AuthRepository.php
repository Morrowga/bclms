<?php

namespace Src\Auth\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;


class AuthRepository implements AuthRepositoryInterface
{
    //login
    public function login($request)
    {

        $user = UserEloquentModel::query()->where('email', $request->email)->first();
        return $user;
    }
    //  register b2c register
    public function b2cRegister($request)
    {

        $name = explode("@", $request->email);
        $user = UserEloquentModel::create([
            "name" => $name[0],
            "email" => $request->email,
            "password" => $request->password,
        ]);

        $user->roles()->sync([2]);

       return $user;
    }

    //verification email
    public function verification($id)
    {


        $decode_id = Crypt::decryptString($id);
        $user = UserEloquentModel::findOrFail($decode_id);
        $user->update([
            "email_verified_at" => Carbon::now()
        ]);

        return  $user;
    }
}
