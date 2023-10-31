<?php

namespace Src\Auth\Domain\Repositories;

interface AuthRepositoryInterface
{
    //login
    public function login($request);

    //  register b2b register
    public function b2cRegister($request);

    //verification email
    public function verification($id);

    public function chooseFreePlan($request);

    public function choosePaidPlan($request);

    public function verificationEmail($email);

    public function searchStudentCode($studentCode);

    public function chooseBothPlan($studentCode);
}
