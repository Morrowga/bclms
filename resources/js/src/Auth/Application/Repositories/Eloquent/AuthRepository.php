<?php

namespace Src\Auth\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Src\Auth\Domain\Mail\VerifyEmail;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;

class AuthRepository implements AuthRepositoryInterface
{
    //login
    public function login($request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $request->email)->first();

        // check if urser exit and allow auth attempt
        if ($user) {
            if (!$user->email_verified_at) {
                $error = "Please Verify your email";
                return Inertia::render('Auth/Presentation/Resources/Login', [
                    "error" => $error
                ]);
            }
            if (auth()->attempt($credentials)) {
                $user->notify(new BcNotification(['message' => 'Welcome ' . $user->name . ' !', 'data' => $user]));

                return redirect()->route('dashboard');
            } else {
                $error = "Invalid Creditional";
                return Inertia::render('Auth/Presentation/Resources/Login', [
                    "error" => $error
                ]);
            }
        }
        // if not fail log in
        else {
            $error = "Invalid Creditional";
            return Inertia::render('Auth/Presentation/Resources/Login', [
                "error" => $error
            ]);
        }
    }
    //  register b2c register
    public function b2cRegister($request)
    {
        $name = explode("@", $request->email);
        $user = User::create([
            "name" => $name[0],
            "email" => $request->email,
            "password" => $request->password,

        ]);

        //  sync 2 mean this user is register using teacher or parent roles
        $user->roles()->sync([2]);

        //send verify email
        Mail::to($request->email)->send(new VerifyEmail($user));
    }

    //verification email
    public function verification($id)
    {
        $decode_id = Crypt::decryptString($id);
        $user = User::find($decode_id);
        $user->update([
            "email_verified_at" => Carbon::now()
        ]);
        return  $user;
    }
}
