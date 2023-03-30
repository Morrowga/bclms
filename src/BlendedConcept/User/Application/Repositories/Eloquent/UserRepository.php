<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Src\Auth\Domain\Mail\VerifyEmail;
use Src\Auth\Domain\Notifications\VerifyUserNotification;
use Src\BlendedConcept\User\Domain\Model\Permission;
use Src\BlendedConcept\User\Domain\Model\Role;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\BlendedConcept\User\Domain\Resources\PermissionResource;
use Src\BlendedConcept\User\Domain\Resources\RoleResource;
use Src\BlendedConcept\User\Domain\Resources\UserResource;

class UserRepository implements UserRepositoryInterface
{

    // get user
    public function getUsers($filters = [])
    {
        //set roles
        $users = UserResource::collection(User::filter($filters)->with('roles')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        return $users;
    }
    //get only user name
    public function getUsersName()
    {
        $user_names = User::pluck('name');
        return $user_names;
    }
    // store user
    public function createUser($request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'contact_number' => $request->contact_number,
                "email" => $request->email,
                "password" => $request->password,
                "is_active" => 1,
                "email_verified_at" => Carbon::now()
            ]
        );

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $user->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
        }

        $roles = Role::where("id", $request->role)->pluck("id");
        $user->roles()->sync($roles);
    }

    //  update user
    public function updateUser($request, $user)
    {

        $user->update($request->only(['name', 'contact_number', 'email']));

        //  delete image if reupload or insert if does not exit
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $old_image = $user->getFirstMedia('image');
            if ($old_image != null) {
                $old_image->delete();

                $user->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
            } else {

                $user->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
            }
        }

        $roles = Role::where("id", $request->role)->pluck("id");
        $user->roles()->sync($roles);
    }
    //user filter
    public function filter($filters = [])
    {
        $query = User::query();

        // Add filters to the query
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        // Return the filtered results
        return $query;
    }

    // get permission
    public function getPermission($filters = [])
    {
        $permissions = PermissionResource::collection(Permission::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_permissions = Permission::all();
        return [
            "permissions" => $permissions,
            "default_permissions" => $default_permissions
        ];
    }

    // store permission
    public function createPermission($request)
    {
        Permission::create($request->only(['name', 'description']));
    }

    // update permission

    public function updatePermission($request, $permission)
    {
        $permission->update($request->only(['name', 'description']));
    }

    // get roles
    public function getRole($filters = [])
    {
        $roles = RoleResource::collection(Role::filter($filters)->with('permissions')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        return $roles;
    }

    //get only roles name
    public function getRolesName()
    {
        $roles_name = Role::pluck('name');
        return $roles_name;
    }


    // store role
    public function createRole($request)
    {
        $role = Role::create($request->only(['name', 'description']));
        $role->permissions()->sync($request->selectedIds);
    }

    //  update role
    public function updateRole($request, $role)
    {
        $role->update($request->only(['name', 'description']));

        $role->permissions()->sync($request->selectedIds);
    }
}
