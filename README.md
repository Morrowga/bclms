Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->json('permissions')->nullable();
    $table->timestamps();
});

Schema::create('role_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('role_id')->constrained();
    $table->foreignId('user_id')->constrained();
    $table->timestamps();
});


#user eloquent

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    public function can($permission)
    {
        return $this->hasPermission($permission);
    }

    protected function hasPermission($permission)
    {
        return $this->roles->flatMap->permissions->contains($permission);
    }
}


#role eloquent

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}


#role repository 


class RoleRepository
{
    public function addPermission(Role $role, $permission)
    {

        $permissions = $role->permissions ?? [];
        if (!in_array($permission, $permissions)) {
            $permissions[] = $permission;
        }
        $role->permissions = $permissions;
        $role->save();
    }

    public function removePermission(Role $role, $permission)
    {
        $permissions = $role->permissions ?? [];
        $key = array_search($permission, $permissions);
        if ($key !== false) {
            array_splice($permissions, $key, 1);
        }
        $role->permissions = $permissions;
        $role->save();
    }
}

#policy 

class PostPolicy
{
    public function create(User $user)
    {
        return $user->hasRole('editor') && $user->can('create_post');
    }
}
