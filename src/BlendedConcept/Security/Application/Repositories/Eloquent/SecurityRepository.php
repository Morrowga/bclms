<?php

namespace Src\BlendedConcept\Security\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Application\DTO\PermissionData;
use Src\BlendedConcept\Security\Application\DTO\RoleData;
use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Application\DTO\UserProfileData;
use Src\BlendedConcept\Security\Application\Mappers\PermissionMapper;
use Src\BlendedConcept\Security\Application\Mappers\RoleMapper;
use Src\BlendedConcept\Security\Application\Mappers\UserMapper;
use Src\BlendedConcept\Security\Domain\Model\Entities\Permission;
use Src\BlendedConcept\Security\Domain\Model\Entities\Role;
use Src\BlendedConcept\Security\Domain\Model\User;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\BlendedConcept\Security\Domain\Resources\PermissionResource;
use Src\BlendedConcept\Security\Domain\Resources\RoleResource;
use Src\BlendedConcept\Security\Domain\Resources\UserResource;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\RoleEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class SecurityRepository implements SecurityRepositoryInterface
{
    //get only user name and i
    public function getUsersNameId()
    {
        $user_names = UserEloquentModel::get();

        return $user_names;
    }

    // get user
    public function getUsers($filters = [])
    {
        //set roles
        $users = UserResource::collection(UserEloquentModel::filter($filters)
            ->with('role', 'b2bUser')
            ->whereNot('role_id', 6)
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));


        return $users;
    }

    public function getB2bTeachers()
    {
        //set roles
        $b2bteachers = B2bUserEloquentModel::with('users')
            ->whereHas('users', function ($query) {
                $query->where('role_id', 4);
            })
            ->orderBy('b2b_user_id', 'desc')->get();

        return UserResource::collection($b2bteachers->pluck('users')->flatten());
    }

    public function getB2bTeachersByOrganization($id)
    {
        $b2bteachers = B2bUserEloquentModel::with('users')
            ->where('organization_id', $id)
            ->whereHas('users', function ($query) {
                $query->where('role_id', 4);
            })
            ->orderBy('b2b_user_id', 'desc')->get();

        return UserResource::collection($b2bteachers->pluck('users')->flatten());
    }

    public function getB2CUsers()
    {
        //set roles
        $b2cUsers = B2cUserEloquentModel::with('users')
            ->whereHas('users')
            ->orderBy('b2c_user_id', 'desc')->get();

        return UserResource::collection($b2cUsers->pluck('users')->flatten());
    }

    public function getBcStaff($filters = [])
    {
        //set roles
        $users = UserResource::collection(UserEloquentModel::filter($filters)
            ->with('role')
            ->where('role_id', 3)
            ->orderBy('id', 'desc')
            ->get());

        return $users;
    }

    //get only user name
    public function getUsersName()
    {
        $users = UserEloquentModel::get();

        $user_names = $users->pluck('full_name');

        return $user_names;
    }

    // store user
    public function createUser(User $user)
    {

        $userEloquent = UserMapper::toEloquent($user);
        //verify email now()
        $userEloquent->email_verified_at = now();
        $userEloquent->save();

        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $userEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
        }

        $userEloquent->roles()->sync(request('role'));
    }

    //  update user
    public function updateUser(UserData $user)
    {

        $userArray = $user->toArray();
        $updateUserEloquent = UserEloquentModel::query()->findOrFail($user->id);
        $updateUserEloquent->fill($userArray);
        $updateUserEloquent->save();

        //  delete image if reupload or insert if does not exit
        if (request()->hasFile('image') && request()->file('image')->isValid()) {

            $old_image = $updateUserEloquent->getFirstMedia('image');
            if ($old_image != null) {
                $old_image->delete();

                $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
            } else {

                $updateUserEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_user');
            }
        }

        $updateUserEloquent->roles()->sync(request('role'));
    }

    public function deleteUser(int $user_id)
    {
        $user = UserEloquentModel::query()->findOrFail($user_id);
        $user->delete();
    }

    //user filter
    public function filter($filters = [])
    {
        $query = UserEloquentModel::query();

        // Add filters to the query
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (isset($filters['email'])) {
            $query->where('email', 'like', '%'.$filters['email'].'%');
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        // Return the filtered results
        return $query;
    }

    // update User Profile
    public function updateUserProfile(UserProfileData $user)
    {
        $userArray = $user->toArray();
        $updateUserEloquent = UserEloquentModel::query()->findOrFail($user->id);
        $updateUserEloquent->fill($userArray);
        $updateUserEloquent->save();
    }

    // get permission
    public function getPermission($filters = [])
    {

        $permissions = PermissionResource::collection(PermissionEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        $default_permissions = PermissionEloquentModel::orderBy('id', 'desc')->get();

        return [
            'permissions' => $permissions,
            'default_permissions' => $default_permissions,
        ];
    }

    // store permission
    public function createPermission(Permission $permission)
    {
        $newPermissionEloquent = PermissionMapper::toEloquent($permission);
        $newPermissionEloquent->save();
    }

    // update permission

    public function updatePermission(PermissionData $permission)
    {
        $permissionArray = $permission->toArray();
        $permissionEloquent = PermissionEloquentModel::query()->findOrFail($permission->id);
        $permissionEloquent->fill($permissionArray);
        $permissionEloquent->save();
    }

    // get roles
    public function getRole($filters = [])
    {
        $paginate_roles = RoleResource::collection(RoleEloquentModel::filter($filters)->with('permissions')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_roles = RoleEloquentModel::with('permissions')->get();

        return [
            'paginate_roles' => $paginate_roles,
            'default_roles' => $default_roles,
        ];
    }

    //get only roles name
    public function getRolesName()
    {
        $roles_name = RoleEloquentModel::get()->prepend('Select');

        return $roles_name;
    }

    // store role
    public function createRole(Role $role)
    {

        $RoleEloquent = RoleMapper::toEloquent($role);
        $RoleEloquent->save();
        $RoleEloquent->permissions()->sync(request('selectedIds'));
    }

    //  update role
    public function updateRole(RoleData $role)
    {

        $roleArray = $role->toArray();
        $roleEloquent = RoleEloquentModel::query()->findOrFail($role->id);
        $roleEloquent->fill($roleArray);
        $roleEloquent->save();
        $roleEloquent->permissions()->sync(request('selectedIds'));
    }

    public function getUserForDashBoard()
    {
        $users = UserEloquentModel::with('role')->latest()->take(5)->get();
        $organizations = OrganizationEloquentModel::latest()->take(5)->get();

        return [$users, $organizations];
    }

    public function changepassword($request)
    {
        $user = Auth::user();
        //  check passord same or not
        if (Hash::check($request->currentpassword, $user->password)) {
            UserEloquentModel::find($user->id)->update([
                'password' => $request->updatedpassword,
            ]);

            return true;
        }

        return false;
    }

    //  update plan
    public function changeStatus($request, $userEloquent)
    {

        DB::beginTransaction();

        try {
            $userEloquent->status = $request->status;
            $userEloquent->update();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function getUserListCount()
    {
        $organization_count = OrganizationEloquentModel::count();

        $b2csubscriper_count = UserEloquentModel::whereHas('role', function ($query) {
            $query->where('name', config('userrole.bcscubscriber'));
        })->count();

        $user_count = UserEloquentModel::count();

        return [
            'organization_count' => $organization_count,
            'b2csubscriper_count' => $b2csubscriper_count,
            'user_count' => $user_count,
        ];
    }
}
