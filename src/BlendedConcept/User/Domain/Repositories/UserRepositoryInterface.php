<?php

namespace Src\BlendedConcept\User\Domain\Repositories;



use Src\BlendedConcept\User\Domain\Model\User;

interface UserRepositoryInterface
{

    // get user
    public function getUsers($filters = [], $perPage = 10);

    // store user
    public function createUser($request);

    //  update user
    public function updateUser($request, $user);


    // server side rendering data for user
    public function filter($filters = []);


    // get permission
    public function getPermission();

    // store permission
    public function createPermission($request);

    //  update permission
    public function updatePermission($request, $permission);

    // get roles
    public function getRole();
    // store role
    public function createRole($request);

    //  update role
    public function updateRole($request, $role);
}
