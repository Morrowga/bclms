<?php

namespace Src\Auth\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Src\Auth\Domain\Mail\VerifyEmail;
use Src\BlendedConcept\User\Infrastructure\UserEloquentModel;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;

class AuthRepository implements AuthRepositoryInterface
{
    //login
    public function login($request)
    {




        $user = UserEloquentModel::query()->where('email', $request->email)->first();

        // check if user exit and allow auth attempt
        if ($user) {
            //this check verify email or not
            if (!$user->email_verified_at) {
                $error = "Please Verify your email";
                return ["errorMessage" => $error, "isCheck" => false];
            }

            if (auth()->attempt([
                "email" => request('email'),
                "password" => request("password")
            ])) {

                $user->notify(new BcNotification(['message' => 'Welcome ' . $user->name . ' !', 'from' => "", 'to' => "", 'type' => "success"]));

                return ["errorMessage" => "Successfully", "isCheck" => true];
            } else {
                $error = "Invalid Login Credential";
                return ["errorMessage" => $error, "isCheck" => false];
            }
        }

        // if not fail log in
        else {

            $error = "Invalid Login Credential";
            return ["errorMessage" => $error, "isCheck" => false];
        }
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
        //  sync 2 mean this user is register using teacher or parent roles

        $user->roles()->sync([2]);

        //here that code that happened run time error

        Mail::to($request->email)->send(new VerifyEmail($user));
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
