<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Hash;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassroomEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

class UserEloquentModel extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'users';

    // for images
    protected $appends = [
        'image',
        'image_url',
        'full_name',
        'organisation_id'
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
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'asc') {
                $query->orderBy('first_name', 'asc');
            } elseif ($filter == 'desc') {
                $query->orderBy('first_name', 'desc');
            } elseif ($filter == 'role') {
                $query->join('roles', 'users.role_id', 'roles.id')->orderBy('name', config('sorting.orderBy'))->select('users.*');
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getOrganisationIdAttribute()
    {
        if ($this->organisation || ($this->b2bUser && $this->b2bUser->organisation)) {
            return ($this->organisation->id ?? $this->b2bUser->organisation->id) ?? null;
        } else if ($this->org_admin) {
            return $this->org_admin->organisation_id;
        }
    }
    public function role_user()
    {
        return $this->belongsTo(RoleEloquentModel::class, 'role_id');
    }

    public function organisation()
    {
        return $this->belongsTo(OrganisationEloquentModel::class, 'id', 'org_admin_id');
    }

    public function b2bUser()
    {
        return $this->hasOne(TeacherEloquentModel::class, 'user_id', 'id')->with('organisation');
    }


    public function parents()
    {
        return $this->hasOne(ParentUserEloqeuntModel::class, 'user_id', 'id')->with('organisation');
    }

    public function org_admin()
    {
        return $this->hasOne(OrganisationAdminEloquentModel::class, 'user_id', 'id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->extractVideoFrameAtSecond(1)
            ->performOnCollections('videos')
            ->format('jpg'); // Specify the format as "jpg"
    }

    public function student()
    {
        return $this->hasOne(StudentEloquentModel::class, 'user_id', 'id')->with(['disability_types', 'parent', 'device']);
    }

    // public function getOrganisationIdAttribute()
    // {
    //     return $this->b2bUser->organisation_id ?? null;
    // }


}
