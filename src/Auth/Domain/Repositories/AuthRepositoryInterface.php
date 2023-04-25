<?php

namespace Src\Auth\Domain\Repositories;



use Src\BlendedConcept\User\Domain\Model\User;

interface AuthRepositoryInterface
{
    //login
    public function login($request);

    //  register b2b register
    public function b2cRegister($request);

    //verification email
    public function verification($id);





}
