<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\RoleEloquentModel;


class UserEloquentModel extends  Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'users';

    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'name',
        'organization_id',
        'email_verified_at',
        'dob',
        'contact_number',
        'storage_limit',
        'password',
        'is_active',
        'stripe_id',
        'pm_brand',
        'pm_last_four',
        'trial_end_at',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }



    public function getRemainingStorageSpace()
    {
        //fetch user's medialibary total uploads size
        $usedSpace = "User Space code is here";

        $remainingSpace = $this->storage_limit - $usedSpace;

        return $remainingSpace;
    }

    public function roles()
    {
        return $this->belongsToMany(RoleEloquentModel::class,'role_user','user_id','role_id');
    }


    // hased password

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }



    public function permissions()
    {
        return $this->hasManyThrough(PermissionEloquentModel::class, RoleEloquentModel::class);
    }

    public function hasPermission($permission)
    {
        $role = auth()->user()->roles[0]->id;
        $user_role = RoleEloquentModel::find($role);
        return $user_role->permissions->where('name', $permission)->first() ? true : false;
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('email','like','%'.$search.'%');
        });
        $query->when($filters['roles'] ?? false, function ($query, $role) {
            $query->whereHas('roles', function ($query) use ($role) {
                $query->where('name', 'like', '%' . $role . '%');
            });
        });
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationEloquentModel::class,'organization_id');
    }
}