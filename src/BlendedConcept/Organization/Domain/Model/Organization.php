<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organization\Domain\Model;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\User\Domain\Model\Role;

class Organization extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;


    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'id',
        'plan_id',
        'name',
        'description',
        'type',
        'contact_person',
        'contact_email',
        'contact_number'
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

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function hasPermission($permission)
    {
        $role = auth()->user()->roles[0]->id;
        $user_role = Role::find($role);

        return $user_role->permissions->where('name', $permission)->first() ? true : false;
    }
}
