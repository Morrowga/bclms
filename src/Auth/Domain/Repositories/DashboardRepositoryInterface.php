<?php

namespace Src\Auth\Domain\Repositories;


interface DashboardRepositoryInterface
{
    //get users according to user login roles
    public function getUsers();
}
