<?php

namespace Src\BlendedConcept\Security\Domain\Repositories;


use Src\BlendedConcept\Security\Application\DTO\PermissionData;
use Src\BlendedConcept\Security\Application\DTO\RoleData;
use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Domain\Model\Entities\Permission;
use Src\BlendedConcept\Security\Domain\Model\Entities\Role;
use Src\BlendedConcept\Security\Domain\Model\User;

interface SecurityRepositoryInterface
{

    //get only user and id
    public function getUsersNameId();
    // get user
    public function getUsers($filters = []);

    // get only user name
    public function getUsersName();

    // store user
    public function createUser(User $user);



    //  update user
    public function updateUser(UserData $user);


    // server side rendering data for user
    public function filter($filters = []);


    // get permission
    public function getPermission($filters = []);

    // store permission
    public function createPermission(Permission $permission);

    //  update permission
    public function updatePermission(PermissionData $permission);

    // get roles
    public function getRole($filters = []);

    //get only roles name
    public function getRolesName();

    // store role
    public function createRole(Role $roleData);

    //  update role
    public function updateRole(RoleData $role);

    public function getUserForDashBoard();


    public function changepassword($request);
}