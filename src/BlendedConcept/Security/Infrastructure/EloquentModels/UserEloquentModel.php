<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Classroom\Infrastructure\EloquentModels\ClassroomEloquentModel;

class UserEloquentModel extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'users';

    // for images
    protected $appends = [
        'image',
        'organization_id',
        'image_url',
        'full_name',
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

    public function getImageUrlAttribute()
    {
        $media = $this->getMedia('image')->first();

        return $media ? $media->getFullUrl() : null;
    }

    public function getRemainingStorageSpace()
    {
        //fetch user's medialibary total uploads size
        $usedSpace = 'User Space code is here';

        $remainingSpace = $this->storage_limit - $usedSpace;

        return $remainingSpace;
    }

    public function role(): HasOne
    {
        return $this->hasOne(RoleEloquentModel::class, 'id', 'role_id');
    }

    // hased password

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function hasPermission($permission)
    {
        $role = auth()->user()->role->id;
        $user_role = RoleEloquentModel::find($role);

        return $user_role->permissions->where('name', $permission)->first() ? true : false;
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
        });
        $query->when($filters['roles'] ?? false, function ($query, $role) {
            $query->whereHas('roles', function ($query) use ($role) {
                $query->where('name', 'like', '%' . $role . '%');
            });
        });
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function role_user()
    {
        return $this->belongsTo(RoleEloquentModel::class, 'role_id');
    }

    public function b2bUser()
    {
        return $this->belongsTo(B2bUserEloquentModel::class, 'id', 'user_id')->with('organization');
    }

    public function b2cUser()
    {
        return $this->belongsTo(B2cUserEloquentModel::class, 'user_id');
    }

    public function getOrganizationIdAttribute()
    {
        return $this->b2bUser->organization_id ?? null;
    }
    public function classrooms()
    {
        return $this->belongsToMany(ClassroomEloquentModel::class, 'classroom_teachers', 'teacher_id', 'classroom_id');
    }
}
