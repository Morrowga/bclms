<?php

namespace Src\Auth\Application\UseCases;

use Src\Auth\Application\Requests\StoreLoginRequest;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;

class AuthService
{
    private AuthRepositoryInterface $repository;

    public function __construct()
    {
      $this->repository = app()->make(AuthRepositoryInterface::class);
    }


   public function Login(StoreLoginRequest $request)
   {
      $user = $this->repository->login($request);

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


}
