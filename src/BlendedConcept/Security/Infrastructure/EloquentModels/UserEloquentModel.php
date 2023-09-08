<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class UserEloquentModel extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'users';

    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'name',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'storage_limit',
        'password',
        'contact_number',
        'status',
        'email_verification_send_on',
        'profile_pic',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verification_send_on' => 'datetime',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function getRemainingStorageSpace()
    {
        //fetch user's medialibary total uploads size
        $usedSpace = 'User Space code is here';

        $remainingSpace = $this->storage_limit - $usedSpace;

        return $remainingSpace;
    }

    public function role() : HasOne
    {
        return $this->hasOne(RoleEloquentModel::class,'id','role_id');
    }

    // hased password

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(PermissionEloquentModel::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function hasPermission($permission)
    {
        $role = auth()->user()->role->id;
        $user_role = RoleEloquentModel::find($role);

        return $user_role->permissions->where('name', $permission)->first() ? true : false;
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        });
        $query->when($filters['roles'] ?? false, function ($query, $role) {
            $query->whereHas('roles', function ($query) use ($role) {
                $query->where('name', 'like', '%'.$role.'%');
            });
        });
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationEloquentModel::class, 'organization_id');
    }
}
