<?php

namespace Src\BlendedConcept\Security\Domain\Services;


use Src\Auth\Application\Requests\StoreRegisterRequest;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class SecurityServices
{
    private AuthRepositoryInterface $repository;

    public function __construct()
    {
      $this->repository = app()->make(AuthRepositoryInterface::class);
    }



    //register B2B user
    public function registerB2CUser(StoreRegisterRequest $request)
    {
        $this->repository->b2cRegister($request);
        Mail::to($request->email)->send(new VerifyEmail($user));

    }
}
