<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

class OrganisationEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'organisations';

    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'id',
        'curr_subscription_id',
        'org_admin_id',
        'name',
        'contact_name',
        'contact_email',
        'contact_number',
        'sub_domain',
        'logo',
        'status',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionEloquentModel::class, 'curr_subscription_id', 'id');
    }

    public function org_admin()
    {
        return $this->belongsTo(OrganisationAdminEloquentModel::class, 'org_admin_id', 'id');
    }

    // public function teachers()
    // {
    //     return $this->hasMany(B2bUserEloquentModel::class, 'organisation_id', 'id');
    // }

    public function students()
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'organisation_students', 'organization_id', 'student_id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'role') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }
}
